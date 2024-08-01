<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function history_order()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $order = Order::where('customer_id', $customer_id)->orderby('created_at', 'desc')->paginate(16);
            $order_first = Order::where('customer_id', $customer_id)->first();
            return view('pages.history.historyOrder')->with(compact('order', 'order_first'));
        } else {
            return view('pages.account-customer.sign-in');
        }
    }
    public function view_history_order($order_code)
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $order = Order::where('customer_id', $customer_id)->where('order_code', $order_code)->orderby('created_at', 'desc')->get();
            foreach ($order as $key => $values) {
                $order_total = $values->order_total;
                $order_reason_cancel = $values->order_reason_cancle;
            }

            //view history order
            $getOrder = Order::where('order_code', $order_code)->first();
            $customer_id = $getOrder->customer_id;
            $shipping_id = $getOrder->shipping_id;
            $order_status = $getOrder->order_status;
            $order_code = $getOrder->order_code;

            $customer = Customer::where('customer_id', $customer_id)->first();
            $shipping = Shipping::with('province')->with('district')->with('wards')->where('shipping_id', $shipping_id)->first();

            $order_detail = OrderDetails::with('product')->where('order_code', $order_code)->get();
            foreach ($order_detail as $key => $ord) {
                $product_coupon = $ord->product_coupon;
                $product_feeship = $ord->product_feeship;
            }
            if ($product_coupon != '0') {
                $coupon = Coupon::where('coupon_code', $product_coupon)->first();
                $coupon_name = $coupon->coupon_name;
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            } else {
                $coupon_name = '';
                $coupon_condition = 2;
                $coupon_number = 0;
            }
            $qty_count = OrderDetails::with('product')->where('order_code', $order_code)->sum('product_sales_quantity');

            return view('pages.history.viewHistoryOrder')->with(compact('order', 'shipping', 'order_detail', 'qty_count', 'product_feeship', 'order_status', 'coupon_number', 'coupon_condition', 'getOrder', 'order_code', 'product_coupon', 'coupon_name', 'order_total', 'order_reason_cancel'));
        } else {
            return view('pages.account-customer.sign-in');
        }
    }
    public function huy_don_hang(Request $request)
    {
        $data = $request->all();
        $order = Order::where('order_code', $data['order_code'])->first();
        if ($order) {
            $order->order_reason_cancle = $data['reason'];
            $order->order_status = 3;
            $order->save();
        } else {
        }
    }
}
