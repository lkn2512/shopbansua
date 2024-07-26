<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryProduct;
use Brian2694\Toastr\Facades\Toastr;
use Brian2694\Toastr\Toastr as ToastrToastr;

class CartController extends Controller
{
    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        $is_avaiable = false;
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $cart[$key]['product_qty'] += $data['cart_product_qty'];
                    $is_avaiable = true;
                    break;
                }
            }
        }
        if (!$is_avaiable) {
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'category' => $data['cart_category_product'],
                'brand' => $data['cart_brand_product'],
            );
        }
        Session::put('cart', $cart);
        Session::save();
    }
    public function your_cart()
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        return view('pages.cart.cart_ajax')->with(compact('category', 'brand'));
    }

    public function delete_product_cart($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
        }
    }
    public function delete_all_product_cart()
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return Redirect()->back();
        } else {
            return Redirect()->back();
        }
    }
    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        $message = null;

        if ($cart) {
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $item) {
                    if ($item['session_id'] == $key) {
                        if ($qty <= $item['product_quantity']) {
                            $cart[$session]['product_qty'] = $qty;
                        } else {
                            $message = "Số lượng bạn đặt đã vượt quá số lượng trong kho của chúng tôi cho sản phẩm {$item['product_name']}.";
                            return Redirect()->back()->with('message', $message);
                        }
                        break; // Break out of inner loop once found
                    }
                }
            }
            Session::put('cart', $cart);
            Toastr::success('Đã cập nhật số lượng sản phẩm', '', ['positionClass' => 'toast-bottom-right']);
        } else {
            $message = 'Giỏ hàng trống hoặc không tồn tại';
        }

        return Redirect()->back()->with('message', $message);
    }

    public function hover_cart_view()
    {
        $cartItems = Session::get('cart', []);
        $cartCount = count($cartItems);

        $output = '';
        $output .= '<li class="cart-items">';
        if ($cartCount > 0) {
            foreach ($cartItems as $value) {
                $output .= '
                    <div class="row info">
                        <div class="col-md-3 imageProduct">
                            <img src="' . asset('/uploads/product/' . $value['product_image']) . '" alt="">
                        </div>
                        <div class="col-md-6">
                            <span class="name">
                                <a href="' . url('chi-tiet-san-pham/' . $value['product_id']) . '" class="name-product-cart">
                            ' . $value['product_name'] . '</a>
                            </span>
                            <span class="price">' . number_format($value['product_price'], 0, ',', '.') . 'đ</span>
                            <button class="remove-cart-view" data-session-id="' . $value['session_id'] . '">Loại bỏ</button>
                        </div>
                        <div class="col-md-3">
                            <span class="qty">Số lượng</span>
                            <span class="number">' . number_format($value['product_qty']) . '</span>
                        </div>
                    </div>
                ';
            }
            $output .= '
                    <div class="row view-group">
                        <a class="view-checkout" href="' . url('checkout/') . '">Thanh toán</a>
                        <a class="view-cart" href="' . url('your-cart/') . '">Xem giỏ hàng</a>
                    </div>
            </li> ';
        } else {
            $output .= '<span>Không có gì trong giỏ hàng của bạn cả!</span>';
        }
        echo $output;
    }
    public function show_cart_quantity()
    {
        $cart_quantity = count(Session::get('cart'));
        $ouput = '';
        $ouput .= '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $cart_quantity . '</span>';
        echo $ouput;
    }
}
