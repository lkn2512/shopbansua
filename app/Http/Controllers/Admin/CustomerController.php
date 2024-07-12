<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FavoritesList;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
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
    public function all_customer()
    {
        $this->AuthLogin();
        $customer = Customer::orderBy('customer_name', 'asc')->get();
        $all_customer = Customer::get();
        foreach ($all_customer as $alc) {
            $get_customerID = $alc->customer_id;
            $get_order_code = $alc->order_code;
        }
        $customerOrders = [];
        foreach ($all_customer as $cus) {
            $customerOrders[$cus->customer_id] = Order::where('customer_id', $cus->customer_id)->count();
        }
        $count_customer = $all_customer->count();
        return view('admin.customer.all-customer')->with(compact('customer', 'customerOrders', 'count_customer'));
    }

    public function add_customer()
    {
        $this->AuthLogin();
        return view('admin.customer.add-customer');
    }

    public function save_customer(Request $request)
    {
        $this->AuthLogin();
        $data = $request->validate(
            [
                'customer_name' => 'required|max:100',
                'customer_email' => 'required|unique:tbl_customers|max:255',
                'customer_phone' => 'required|unique:tbl_customers|max:15',
                'customer_address' => '',
                'customer_img' => '',
                'customer_password' => 'required',
            ],
            [
                'customer_email.unique' => 'Email đã tồn tại',
                'customer_phone.unique' => 'Số điện thoại đã tồn tại',
                'customer_phone.max' => 'Số điện thoại không được vượt quá :max số'
            ]
        );

        $customer = new Customer();
        $customer->customer_name = $data['customer_name'];
        $customer->customer_phone = $data['customer_phone'];
        $customer->customer_address = $data['customer_address'];

        $get_image = $request->file('customer_img');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path('/uploads/customer'), $new_image);
            $customer->customer_image = $new_image;
        } else {
            $customer->customer_image = '';
        }

        $customer->customer_email = $data['customer_email'];
        $customer->customer_password =  bcrypt($data['customer_password']);
        $customer->save();
        Toastr::success('Thêm khách hàng thành công!', 'Thành công');
        return Redirect::to('Admin/add-customer');
    }

    public function delete_customer($customer_id)
    {
        $this->AuthLogin();
        try {
            $customer = Customer::findOrFail($customer_id);
            $orders = Order::where('customer_id', $customer->customer_id)->get();
            foreach ($orders as $order) {
                Notification::where('order_code', $order->order_code)->delete();
                OrderDetails::where('order_code', $order->order_code)->delete();
                $order->delete();
            }
            $shippingIds = $orders->pluck('shipping_id')->unique();
            Shipping::whereIn('shipping_id', $shippingIds)->delete();
            FavoritesList::where('customer_id', $customer->customer_id)->delete();
            $customer->delete();
            return response()->json(['status' => 'success', 'message' => 'Đã xoá một tài khoản khách hàng!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi bất định!']);
        }
    }
    public function info_customer($customer_id)
    {
        $this->AuthLogin();
        $query = Order::with('customer')->where('customer_id', $customer_id);

        $customer = Customer::where('customer_id', $customer_id)->get();
        $order = Order::where('customer_id', $customer_id)->orderby('created_at', 'desc')->get();

        $order_total = $query->count();
        $order_delivered = $query->where('order_status', 2)->sum('order_total');
        $order_delivered_count = $query->where('order_status', 2)->count();

        $orders = Order::where('customer_id', $customer_id);
        $order_average = $orders->avg('order_total');

        return view('admin.customer.info-customer')->with(compact('customer', 'order_total', 'order_delivered', 'order_delivered_count', 'order', 'order_average'));
    }

    public function update_avatar_customer(Request $request)
    {
        $this->AuthLogin();
        $customer_id = $request->input('customer_id');
        $get_image = $request->file('file_img');

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
                } else {
                    return Redirect()->back()->with('error_alert', 'Khách hàng không tồn tại!');
                }
            } else {
                return Redirect()->back()->with('error_alert', 'Lỗi định dạng file!');
            }
        } else {
            return Redirect()->back()->with('error_alert', 'Không có tệp nào được chọn!');
        }
        Toastr::success('Ảnh đại diện đã được thay đổi!');
        return Redirect()->back();
    }
    public function edit_info_customer(Request $request, $customer_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $data = $request->except('_token');
        $data['customer_address'] = $request->customer_address;
        $data['customer_phone'] = $request->customer_phone;

        if ($customer_id) {
            Customer::where('customer_id', $customer_id)->update($data);
            Toastr::success('Đã cập nhật lại thông tin khách hàng!');
            return redirect()->back();
        } else {
            return redirect()->back()->with('error_alert', 'Không tìm thấy khách hàng này');
        }
    }
}
