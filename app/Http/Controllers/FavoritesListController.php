<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\FavoritesList;

class FavoritesListController extends Controller
{
    public function checkFavorite(Request $request)
    {
        $product_id = $request->product_id;
        $customer_id = $request->customer_id;
        $isFavorite = FavoritesList::where('customer_id', $customer_id)->where('product_id', $product_id)->exists();
        $output = '';
        if ($isFavorite) {
            $output .= '<i class="fa-solid fa-heart favorite-red"></i>';
        } else {
            $output .= '
        <button class="button_favorite add_favorite" data-id="' . $product_id . '"
        data-customer_id="' . $customer_id . '"><span class="favorite-text"><i
                class="fa-solid fa-heart-circle-plus icon-favo"></i>Yêu thích</span>
        </button>';
        }

        echo $output;
    }
    public function add_favorites_list(Request $request)
    {
        $product_id = $request->product_id;
        $customer_id = $request->customer_id;

        $favorites_list = new FavoritesList();
        $favorites_list->product_id = $product_id;
        $favorites_list->customer_id = $customer_id;
        $favorites_list->save();
    }
    public function favorites_list(Request $request)
    {
        $list_favorite = FavoritesList::where('customer_id', $request->favorite_customer_id)->get();
        $output = '';
        $hasFavorites = count($list_favorite) > 0;
        if ($hasFavorites) {
        } else {
            $output .= '<span style="font-size:18px; opacity:0.7">Hiện không có sản phẩm nào trong danh sách yêu thích của bạn!</span>';
        }
        $output .= '<div class="row product-row-container">';
        foreach ($list_favorite as $fa) {
            $product = Product::find($fa->product_id);
            if ($product) {
                $output .= '
                        <div class="col-lg-3 col-md-4 col-sm-6 product-content">
                            <div class="productinfo">
                                <a class="unFavorite" type="button" data-id="' . $fa->favorite_id . '" title="Bỏ yêu thích"><i class="fa-solid fa-xmark"></i></a>
                                <a class="img-center">
                                    <img class="img-products" src="' . url('/uploads/product/' . $product->product_image) . '" />';
                if ($product->promotional_price > 0) {
                    $output .= '    <span class="header-image-promotional">Khuyến mãi đặc biệt</span>';
                }
                $output .= '    </a>
                                <a href="' . url('chi-tiet-san-pham/' . $product->product_id) . '">
                                    <p class="product-name">' . $product->product_name . '</p>
                                </a>';
                $output .= '    <div class="price-product">';
                if ($product->promotional_price > 0) {
                    $output .= '    <div class="price-info">
                                        <div class="price-content1">
                                            <small class="price-small">' . number_format($product->product_price, 0, ',', '.') . '
                                            </small>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                        <div class="price-content2">
                                            <span class="promotional-price">
                                                ' . number_format($product->product_price, 0, ',', '.') . '
                                            </span>
                                            <span class="currency-unit">₫</span>
                                        </div>
                                    </div>';
                } else {
                    $output .= '    <div class="price-content">
                                        <span class="price"> ' . number_format($product->product_price, 0, ',', '.') . '</span>
                                        <span class="currency-unit">₫</span>
                                    </div>';
                }
                $output .= '    </div>';
                $output .= '    <form>
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" class="cart_product_id_' . $product->product_id . '"
                                        value="' . $product->product_id . '">
                                    <input type="hidden" class="cart_product_name_' . $product->product_id . '"
                                        value="' . $product->product_name . '">
                                    <input type="hidden" class="cart_product_image_' . $product->product_id . '"
                                        value="' . $product->product_image . '">
                                    <input type="hidden" class="cart_product_quantity_' . $product->product_id . '"
                                        value="' . $product->product_quantity . '">';
                if ($product->promotional_price > 0) {
                    $output .= '    <input type="hidden" class="cart_product_price_' . $product->product_id . '"
                                        value="' . $product->promotional_price . '">';
                } else {
                    $output .= '    <input type="hidden" class="cart_product_price_' . $product->product_id . '"
                                        value="' . $product->product_price . '">';
                }
                $output .= '        <input type="hidden" class="cart_category_product_' . $product->product_id . '"
                                        value="' . $product->category->category_name . '">
                                    <input type="hidden" class="cart_brand_product_' . $product->product_id . '"
                                        value="' . $product->brand->brand_name . '">
                                    <input type="hidden" class="cart_product_qty_' . $product->product_id . '" value="1">
                                    <div class="order-button">
                                        <a class="add-to-cart" data-id="' . $product->product_id . '"><i
                                                class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                                        </a>
                                    </div>
                                </form>';
                $output .= '</div>
                        </div>';
            }
        }
        $output .= '<div>';
        echo $output;
    }
    public function delete_favorite(Request $request)
    {
        $favorite_id = $request->favorite_id;
        $favorites_list = FavoritesList::find($favorite_id);
        if ($favorites_list) {
            $favorites_list->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
