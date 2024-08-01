<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Information;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintPDFController extends Controller
{
    public function printOrder($order_code)
    {
        // Lấy thông tin đơn hàng dựa trên mã đơn hàng

        $contact_printPDF = Information::get();

        $order = Order::where('order_code', $order_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
            $order_code = $ord->order_code;
            $order_date = $ord->created_at;
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

        $data = [
            'order' => $order,
            'order_detail' => $order_detail,
            'shipping' => $shipping,
            'customer' => $customer,
            'contact_printPDF' => $contact_printPDF,
            'qty_count' => $qty_count,
            'product_feeship' => $product_feeship,
            'order_status' => $order_status,
            'coupon_number' => $coupon_number,
            'coupon_condition' => $coupon_condition,
            'product_coupon' => $product_coupon,
            'coupon_name' => $coupon_name,
            'order_code' => $order_code,
            'order_date' => $order_date,
        ];
        $pdf = PDF::loadView('admin.printPDF.print_order', $data);
        return $pdf->stream('order_' . $order_code . '.pdf');
    }
}
