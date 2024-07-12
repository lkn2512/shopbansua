<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class OrderController extends Controller
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
    public function manage_order()
    {
        $this->AuthLogin();
        $order = Order::with('notification')->orderby('created_at', 'desc')->get();
        $all_order = Order::get();
        $count_order = $all_order->count();

        $order_total = Order::with('customer')->orderby('created_at', 'desc')->get();

        return view('admin.order.manage_order')->with(compact('order', 'count_order', 'order_total'));
    }

    public function view_order($order_code)
    {
        $this->AuthLogin();
        $order = Order::where('order_code', $order_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
            $order_code = $ord->order_code;
            $order_date = $ord->created_at;
            $order_reason_cancel = $ord->order_reason_cancle;
        }

        $notification = Notification::where('read', 0)->where('order_code', $order_code)->first();
        if ($notification) {
            $notification->delete();
        }

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

        return view('admin.order.view_order')->with(compact('order', 'customer', 'shipping', 'order_detail', 'qty_count', 'product_feeship', 'order_status', 'coupon_number', 'coupon_condition', 'product_coupon', 'coupon_name', 'order_code', 'order_date', 'order_reason_cancel'));
    }

    public function update_order_quantity(Request $request)
    {
        $this->AuthLogin();
        //update order
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        //order date
        $order_date = $order->order_date;
        $statistic = Statistic::where('order_date', $order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }
        if ($order->order_status == 2) {
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;

                $product_price = $product->product_price;
                $product_cost = $product->product_cost;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key == $key2) {
                        $pro_remain = $product_quantity - $qty;
                        $product->product_quantity = $pro_remain;
                        $product->product_sold = $product_sold + $qty;
                        $product->save();

                        //cap nhat doanh thu
                        $quantity += $qty;
                        $total_order += 1;
                        $sales += ($product_price * $qty);
                        $profit += ($product_price - $product_cost) * $qty;
                    }
                }
            }
            //cap nhat doanh thu db
            if ($statistic_count > 0) {
                $statistic_update = Statistic::where('order_date', $order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            } else {
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
        } elseif ($order->order_status != 2 && $order->order_status != 3) {
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;

                $product_price = $product->product_price;
                $product_cost = $product->product_cost;
                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key == $key2) {
                        $pro_remain = $product_quantity + $qty;
                        $product->product_quantity = $pro_remain;
                        $product->product_sold = $product_sold - $qty;
                        $product->save();

                        //cap nhat doanh thu
                        $quantity += $qty;
                        $total_order += 1;
                        $sales += ($product_price * $qty);
                        $profit += ($product_price - $product_cost) * $qty;
                    }
                }
            }
            $statistic_update = Statistic::where('order_date', $order_date)->first();
            $statistic_update->sales = $statistic_update->sales - $sales;
            $statistic_update->profit = $statistic_update->profit - $profit;
            $statistic_update->quantity = $statistic_update->quantity - $quantity;
            $statistic_update->total_order = $statistic_update->total_order - $total_order;
            $statistic_update->save();
        }
    }
}
