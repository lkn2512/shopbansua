<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function info_customer()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
            $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

            $query = Order::with('customer')->where('customer_id', $customer_id);

            $customer = Customer::where('customer_id', $customer_id)->get();
            $order = Order::where('customer_id', $customer_id)->orderby('created_at', 'desc')->paginate(10);

            $order_total = $query->count();
            $order_delivered = $query->where('order_status', 2)->sum('order_total');
            $order_delivered_count = $query->where('order_status', 2)->count();

            $orders = Order::where('customer_id', $customer_id);
            $order_average = $orders->avg('order_total');

            return view('pages.customer-page.info-customer')->with(compact('category', 'brand', 'customer', 'order_total', 'order_delivered', 'order_delivered_count', 'order', 'order_average'));
        } else {
            return Redirect::to('login');
        }
    }
    public function setting_info_customer()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
            $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

            $customer = Customer::where('customer_id', $customer_id)->get();
            return view('pages.customer-page.setting-customer')->with(compact('category', 'brand', 'customer'));
        } else {
            return Redirect::to('login');
        }
    }
    public function upload_avatar_customer(Request $request, $customer_id)
    {
        $get_image = $request->file('customer_image');

        if ($get_image) {
            $mime_type = $get_image->getClientMimeType();
            if (strpos($mime_type, 'image') !== false) {
                $customer = Customer::find($customer_id);
                if ($customer) {
                    $customer_image = $customer->customer_image;
                    if ($customer_image && file_exists(public_path('uploads/customer/' . $customer_image))) {
                        unlink(public_path('uploads/customer/' . $customer_image));
                    }
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                    $get_image->move(public_path('uploads/customer/'), $new_image);
                    $customer->customer_image = $new_image;
                    $customer->save();
                }
            } else {
                return Redirect()->back()->with('message', 'Định dạng tập tin không hợp lệ');
            }
        } else {
            return Redirect()->back()->with('error_alert', 'Không có tệp nào được chọn!');
        }
        Toastr::success('Ảnh đại diện đã được thay đổi!', '', ['positionClass' => 'toast-bottom-right']);
        return Redirect()->back();
    }
    public function update_info_customer(Request $request, $customer_id)
    {
        $data = $request->all();
        $existingCustomer = Customer::where('customer_phone', $data['customer_phone'])->first();
        if ($existingCustomer && $existingCustomer->customer_id != $customer_id) {
            Toastr::error('Số điện thoại đã được sử dụng', 'Thất bại', ['positionClass' => 'toast-top-right']);
            return Redirect()->back()->with('message', '');
        }
        $customer = Customer::findOrFail($customer_id);
        $customer->customer_name = $data['customer_name'];
        $customer->customer_address = $data['customer_address'];
        $customer->customer_phone = $data['customer_phone'];
        $customer->save();
        Toastr::success('Đã cập nhật thông tin cá nhân', '', ['positionClass' => 'toast-bottom-right']);
        return Redirect()->back();
    }

    public function change_email_customer(Request $request)
    {
        $customer_id = Session::get('customer_id');
        try {
            if ($customer_id) {
                $data = $request->all();
                $data = $request->except('_token');
                $data['customer_email'] = $request->customer_email;
                Customer::where('customer_id', $customer_id)->update($data);
                Toastr::success('Thay đổi email thành công!', 'Thành công');
                return redirect()->back();
            } else {
                return Redirect::to('login');
            }
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    public function change_password_customer(Request $request)
    {
        try {
            $customer_id = Session::get('customer_id');
            $customer = Customer::find($customer_id);
            if (!$customer) {
                return redirect()->back()->with('message', 'Không tìm thấy khách hàng.');
            }
            if (!Hash::check($request->old_password, $customer->customer_password)) {
                return redirect()->back()->with('message', 'Mật khẩu cũ không chính xác.');
            }
            $customer->customer_password = Hash::make($request->new_password);
            $customer->save();
            Toastr::success('Thay đổi mật khẩu thành công!', 'Thành công');
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
