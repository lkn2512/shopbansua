<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\FavoritesList;

class FavoritesListController extends Controller
{

    public function add_favorites_list(Request $request)
    {
        $product_id = $request->product_id;
        $customer_id = $request->customer_id;
        $existing_favorite = FavoritesList::where('customer_id', $customer_id)->where('product_id', $product_id)->first();

        if (!$existing_favorite) {
            $favorites_list = new FavoritesList();
            $favorites_list->product_id = $product_id;
            $favorites_list->customer_id = $customer_id;
            $favorites_list->save();
            return response()->json(['message' => 'Đã thêm vào danh sách yêu thích.']);
        } else {
            return response()->json(['error' => 'Sản phẩm này đã có trong danh sách yêu thích của bạn.'], 400);
        }
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
        $output .= '<div class="row row-content">';
        foreach ($list_favorite as $fa) {
            $product = Product::find($fa->product_id);
            if ($product) {
                $output .= '
                    <div class="col-md-3">
                        <div class="col-border">
                            <div class="mb-5">
                                <div class="single-products">
                                    <div class="productinfo">
                                        <form>
                                         <a class="unFavorite" type="button" data-id="' . $fa->favorite_id . '" title="Bỏ yêu thích"><i class="fa-solid fa-xmark"></i></a>
                                            <a class="img-center">
                                                <img class="img-products" src="' . url('/uploads/product/' . $product->product_image) . '" />';
                if ($product->promotional_price > 0) {
                    $output .= ' <span class="header-image-promotional">Khuyến mãi đặc biệt</span>';
                }
                $output .= ' </a>
                                            <a href="' . url('chi-tiet-san-pham/' . $product->product_id) . '">
                                                <p class="product-name">' . $product->product_name . '</p>
                                            </a>';
                if ($product->promotional_price > 0) {
                    $output .= ' <div class="price-info">
                                    <small class="price-small">' . number_format($product->product_price, 0, ',', '.') . '
                                        <span class="currency-unit">₫</span>
                                    </small>
                                    <span class="promotional-price">
                                        ' . number_format($product->product_price, 0, ',', '.') . '
                                        <span class="currency-unit">₫</span>
                                    </span>
                                </div>';
                } else {
                    $output .= ' <h2> ' . number_format($product->product_price, 0, ',', '.') . '
                                    <span class="currency-unit">₫</span>
                                </h2>';
                }
                $output .= ' </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    public function deleteAll_favorites(Request $request)
    {
        $customer_id = $request->customer_id;
        FavoritesList::where('customer_id', $customer_id)->delete();
        return response()->json(['success' => true]);
    }
}
