<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\OrderDetails;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
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
    public function insert_coupon(Request $request)
    {
        $this->AuthLogin();
        $coupon_list = Coupon::orderby('coupon_id', 'desc')->get();
        return view('admin.coupon.insert_coupon')->with(compact('coupon_list'));
    }
    public function list_coupon(Request $request)
    {
        $this->AuthLogin();
        $coupon = Coupon::orderby('coupon_id', 'desc')->get();
        $all_coupont = Coupon::get();
        $count_coupon = $all_coupont->count();

        return view('admin.coupon.list_coupon')->with(compact('coupon', 'count_coupon'));
    }

    public function active_coupon($coupon_id)
    {
        $this->AuthLogin();
        Coupon::where('coupon_id', $coupon_id)->update(['coupon_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Mã giảm giá đã mở khoá.']);
    }
    public function unactive_coupon($coupon_id)
    {
        $this->AuthLogin();
        Coupon::where('coupon_id', $coupon_id)->update(['coupon_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Mã giảm giá đã khoá.']);
    }

    public function insert_coupon_code(Request $request)
    {
        $this->AuthLogin();
        try {
            $data = $request->all();
            $coupon = new Coupon();
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_time = $data['coupon_times'];
            $coupon->coupon_condition = $data['coupon_condition'];
            $coupon->coupon_number = $data['coupon_number'];
            $coupon->coupon_date_start = $data['coupon_date_start'];
            $coupon->coupon_date_end = $data['coupon_date_end'];
            $coupon->save();
            return response()->json(['success' => 'Thêm mã giảm giá thành công.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Lỗi bất định, vui lòng tải lại trang']);
        }
    }
    public function edit_coupon($coupon_id)
    {
        $this->AuthLogin();
        $edit_coupon_code = Coupon::where('coupon_id', $coupon_id)->get();
        $coupon_list = Coupon::orderby('coupon_id', 'desc')->get();

        foreach ($edit_coupon_code as $ed) {
            $get_couponCode = $ed->coupon_code;
        }
        $order_details_check = OrderDetails::where('product_coupon', $get_couponCode)->count();

        return view('admin.coupon.edit_coupon')->with(compact('edit_coupon_code', 'coupon_list', 'order_details_check'));
    }
    public function update_coupon(Request $request, $coupon_id)
    {
        $this->AuthLogin();
        try {
            $data = $request->all();
            $coupon = Coupon::find($coupon_id);
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_time = $data['coupon_times'];
            $coupon->coupon_condition = $data['coupon_condition'];
            $coupon->coupon_number = $data['coupon_number'];
            $coupon->coupon_date_start = $data['coupon_date_start'];
            $coupon->coupon_date_end = $data['coupon_date_end'];
            $coupon->save();
            return response()->json(['success' => 'Đã cập nhật thay đổi']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Lỗi bất định, vui lòng tải lại trang']);
        }
    }
    public function delete_coupon($coupon_id)
    {
        $this->AuthLogin();
        try {
            $coupon = Coupon::find($coupon_id);
            if ($coupon) {
                $get_couponCode = $coupon->coupon_code;
                $order_details = OrderDetails::where('product_coupon', $get_couponCode)->count();
                if ($order_details == 0) {
                    $coupon->delete();
                    return response()->json(['status' => 'success', 'message' => 'Một mã giảm giá đã bị xoá.']);
                } else {
                    return response()->json(['status' => 'info', 'message' => 'Mã giảm giá đã được sử dụng.']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Một mã giảm giá không tồn tại.']);
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá mã giảm giá.', 'error' => $e->getMessage()]);
        }
    }
}
