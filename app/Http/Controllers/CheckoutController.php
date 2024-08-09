<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Coupon;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $cart = Session::get('cart');
            $exceeded = false;
            if ($cart) {
                foreach ($cart as $key => $val) {
                    if ($val['product_qty'] > $val['product_quantity']) {
                        $exceeded = true;
                        break;
                    }
                }
                if ($exceeded) {
                    return Redirect::to('your-cart')->with('message', 'Không thể thanh toán. Một vài sản phẩm bạn đặt đã vượt quá số lượng trong kho của chúng tôi');
                } else {
                    $latestOrder = Order::where('customer_id', $customer_id)->latest()->first();
                    if ($latestOrder) {
                        $shipping_id = $latestOrder->shipping_id;
                        $shippingInfoLast = Shipping::with('province')->with('district')->with('wards')->where('shipping_id', $shipping_id)->first();
                    } else {
                        $shippingInfoLast = null;
                    }
                    return view('pages.checkout.show_checkout')->with(compact('shippingInfoLast'));
                }
            } else {
                return Redirect::to('your-cart');
            }
        } else {
            return Redirect::to('login');
        }
    }

    public function check_coupon(Request $request)
    {
        $data = $request->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh');
        $todayFormatted = $today->format('Y-m-d');

        $customer_id = Session::get('customer_id');
        $coupon = Coupon::where('coupon_code', $data['coupon'])
            ->where('coupon_status', 1)
            ->whereDate('coupon_date_end', '>=', $todayFormatted)
            ->where(function ($query) use ($customer_id) {
                $query->whereRaw("FIND_IN_SET(?, coupon_used) > 0", [$customer_id])
                    ->orWhereRaw("FIND_IN_SET(?, coupon_used) = 1", [$customer_id]);
            })
            ->first();

        if ($coupon) {
            Session::put('message', "Mã giảm giá này chỉ được sử dụng 1 lần");
            return Redirect()->back();
        } else {
            $coupon_apply = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->whereDate('coupon_date_end', '>=', $todayFormatted)->first();
            if ($coupon_apply) {
                $count_coupon = $coupon_apply->count();
                if ($count_coupon > 0) {
                    $coupon_session = Session::get('coupon');
                    if ($coupon_session) {
                        $is_avaiable = 0;
                        if ($is_avaiable == 0) {
                            $cou[] = array(
                                'coupon_name' => $coupon_apply->coupon_name,
                                'coupon_code' => $coupon_apply->coupon_code,
                                'coupon_condition' => $coupon_apply->coupon_condition,
                                'coupon_number' => $coupon_apply->coupon_number,
                            );
                            Session::put('coupon', $cou);
                        }
                    } else {
                        $cou[] = array(
                            'coupon_name' => $coupon_apply->coupon_name,
                            'coupon_code' => $coupon_apply->coupon_code,
                            'coupon_condition' => $coupon_apply->coupon_condition,
                            'coupon_number' => $coupon_apply->coupon_number,
                        );
                        Session::put('coupon', $cou);
                    }
                    Session::save();
                    return Redirect()->back();
                }
            } else {
                Session::put('message', "Mã giảm giá không chính xác hoặc đã hết hạn!");
                return Redirect()->back();
            }
        }
    }
    public function remove_coupon()
    {
        $coupon = Session::get('coupon');
        if ($coupon == true) {
            Session::forget('coupon');
            return Redirect()->back();
        } else {
            return Redirect()->back();
        }
    }
    // public function payment()
    // {
    //     return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product);
    // }

    public function confirm_order(Request $request)
    {
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->matp = $data['shipping_address_city'];
        $shipping->maqh = $data['shipping_address_district'];
        $shipping->xaid = $data['shipping_address_wards'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_notes = $data['shipping_notes'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_get_id = $shipping->shipping_id;

        $order_code_random = substr(md5(microtime()), rand(0, 26), 10);
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_get_id;
        $order->order_status = 1;
        $order->order_code = $order_code_random;
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->order_date = $order_date;
        $order->order_total = $data['order_total'];
        $order->save();

        //Trừ đi số lượng mã giảm giá khi đặt hạng (nếu có)
        $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
        if ($coupon) {
            $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
            $coupon->coupon_time = $coupon->coupon_time - 1;
            $coupon->save();
        }

        if (Session::get('cart')) {
            foreach (Session::get('cart') as $cart) {
                $order_details = new OrderDetails();
                $order_details->order_code = $order->order_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->price = $cart['product_price'];
                $order_details->save();
            }
        }

        // Create a new notification
        $notification = new Notification();
        $notification->message = 'Đơn hàng mới';
        $notification->order_code = $order->order_code;
        $notification->save();

        Session::forget('coupon');
        Session::forget('cart');
    }
}
