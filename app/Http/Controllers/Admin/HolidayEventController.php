<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HolidayEvent;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HolidayEventController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('user_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('Admin/admin-login')->send();
        }
    }
    public function list_holidays()
    {
        $this->AuthLogin();
        // Lấy danh sách các sự kiện và sắp xếp theo ngày diễn ra giảm dần
        $holidayEvent = HolidayEvent::orderBy('event_date', 'desc')->get();
        $count_holiday = $holidayEvent->count();

        $productCounts = [];
        foreach ($holidayEvent as $event) {
            // Đếm số lượng sản phẩm có tham gia vào sự kiện hiện tại
            $count = $event->products()->count();
            $productCounts[$event->event_name] = $count;
        }
        return view('admin.holiday-event.list-holidays')->with(compact('holidayEvent', 'count_holiday', 'productCounts'));
    }
    public function add_holiday_event_page(Request $request)
    {
        $this->AuthLogin();
        $products = Product::orderBy('product_name', 'asc')->get();

        return view('admin.holiday-event.add-holiday-event', compact('products'));
    }
    public function save_holiday_event(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $validator = Validator::make($data, [
            'event_name' => 'required|max:255',
            'event_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_date',
            'products' => 'required|array|min:3',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'event_end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày diễn ra.',
            'event_image.max' => 'Hình ảnh sự kiện không được vượt quá 2MB.',
            'products.required' => 'Vui lòng chọn ít nhất 3 sản phẩm.',
            'products.min' => 'Vui lòng chọn ít nhất 3 sản phẩm.',
        ]);
        if ($validator->fails()) {
            $customMessages = $validator->messages()->toArray();
            return response()->json(['info' => $customMessages], 422);
        }
        // Save event information to database
        $holidayEvent = new HolidayEvent();
        $holidayEvent->event_name = $data['event_name'];
        $holidayEvent->event_date = $data['event_date'];
        $holidayEvent->event_end_date = $data['event_end_date'];
        $holidayEvent->event_status = $data['event_status'];
        if ($request->hasFile('event_image')) {
            $image = $request->file('event_image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/event/'), $imageName);
            $holidayEvent->event_image = $imageName;
        }
        $holidayEvent->save();
        // Save participating products to pivot table event_product
        $holidayEvent->products()->attach($data['products']);

        return response()->json(['success' => 'Sự kiện đã được khởi tạo']);
    }

    public function edit_holiday_event_page(Request $request, $holiday_event_id)
    {
        $this->AuthLogin();
        // Lấy thông tin sự kiện dựa trên holiday_event_id
        $holidayEvent = HolidayEvent::findOrFail($holiday_event_id);
        // Lấy danh sách tất cả sản phẩm, sắp xếp theo tên
        $products = Product::orderBy('product_name', 'asc')->get();
        // Lấy danh sách các sản phẩm đã được chọn (thuộc sự kiện hiện tại)
        $selectedProducts = $holidayEvent->products()->pluck('tbl_product.product_id')->toArray();

        return view('admin.holiday-event.edit-holiday-event', compact('products', 'holidayEvent', 'selectedProducts'));
    }
    public function update_holiday_event(Request $request, $holiday_event_id)
    {
        $this->AuthLogin();
        $data = $request->all();

        // Validate dữ liệu
        $validator = Validator::make($data, [
            'event_name' => 'required|max:255',
            'event_date' => 'required|date',
            'event_end_date' => 'required|date|after_or_equal:event_date',
            'products' => 'required|array|min:3',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'products.min' => 'Vui lòng chọn ít nhất 3 sản phẩm.',
            'event_end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày diễn ra.'
        ]);

        if ($validator->fails()) {
            $customMessages = $validator->messages()->toArray();
            return response()->json(['info' => $customMessages], 422);
        }
        // Lấy thông tin sự kiện cần cập nhật từ cơ sở dữ liệu
        $holidayEvent = HolidayEvent::findOrFail($holiday_event_id);

        // Cập nhật thông tin sự kiện
        $holidayEvent->event_name = $data['event_name'];
        $holidayEvent->event_date = $data['event_date'];
        $holidayEvent->event_end_date = $data['event_end_date'];
        $holidayEvent->event_status = $data['event_status'];

        // Xử lý hình ảnh sự kiện nếu có
        if ($request->hasFile('event_image')) {
            $image = $request->file('event_image');

            // Xóa hình ảnh cũ nếu có
            $current_image = $holidayEvent->event_image;
            if ($current_image && file_exists(public_path('uploads/event/' . $current_image))) {
                unlink(public_path('uploads/event/' . $current_image));
            }

            // Lưu hình ảnh mới
            $image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/event/'), $image_name);
            $holidayEvent->event_image = $image_name;
        }
        // Lưu sự kiện và các sản phẩm tham gia
        $holidayEvent->save();
        $holidayEvent->products()->sync($data['products']);
        return response()->json([
            'success' => 'Cập nhật sự kiện thành công',
            'id' => $holiday_event_id,
            'new_image_path' => isset($image_name) ? asset('uploads/event/' . $image_name) : null
        ]);
    }

    public function delete_holiday_event($holiday_event_id)
    {
        $this->AuthLogin();
        $event = HolidayEvent::findOrFail($holiday_event_id);
        $img = $event->event_image;
        if ($img && file_exists(public_path('uploads/event/' . $img))) {
            unlink(public_path('uploads/event/' . $img));
        }
        $event->delete();
        // Sử dụng detach để xoá các bản ghi liên quan đến sự kiện này
        $event->products()->detach();

        return response()->json(['status' => 'success', 'message' => 'Một sự kiện đã bị xoá.']);
    }

    public function unactive_holiday_event($holiday_event_id)
    {
        $this->AuthLogin();
        HolidayEvent::where('holiday_event_id', $holiday_event_id)->update(['event_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_holiday_event($holiday_event_id)
    {
        $this->AuthLogin();
        HolidayEvent::where('holiday_event_id', $holiday_event_id)->update(['event_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }
}
