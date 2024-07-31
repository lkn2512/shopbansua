<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;

class CategoryProductController extends Controller
{
    public function show_category_home(Request $request, $category_id)
    {
        // Bắt đầu query để lấy sản phẩm
        $query = Product::where('category_id', $category_id)->where('product_status', '1')->where('product_condition', '1');

        // Lấy danh mục và các thương hiệu có sản phẩm trong danh mục đó
        $category_filter = CategoryProduct::where('category_id', $category_id)->where('category_status', '1')->orderBy('category_name', 'asc')->get();

        // Lấy danh sách thương hiệu có sản phẩm trong danh mục đã chọn
        $brands = Brand::whereHas('product', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        // Kiểm tra nếu danh sách thương hiệu không rỗng
        if ($brands->isNotEmpty()) {
            // Lấy mảng các brand_id từ danh sách thương hiệu
            $brand_ids = $brands->pluck('brand_id')->toArray();

            // Sử dụng mảng brand_id để lấy các thương hiệu lọc
            $brand_filter = Brand::whereIn('brand_id', $brand_ids)
                ->where('brand_status', '1')
                ->orderBy('brand_name', 'asc')
                ->get();
        } else {
            // Nếu không có thương hiệu nào, trả về mảng rỗng
            $brand_filter = collect([]);
        }

        // Lấy giá sản phẩm tối thiểu và tối đa
        $min_price = $query->min('product_price');
        $max_price = $query->max('product_price');

        // Lấy tên danh mục
        $category_name = CategoryProduct::where('category_id', $category_id)->limit(1)->get();

        // Lọc theo thương hiệu nếu có
        if ($request->has('brand')) {
            $brand_ids = explode(',', $request->brand);
            $query->whereIn('brand_id', $brand_ids);
        }

        // Sắp xếp sản phẩm theo yêu cầu
        if ($request->has('sort_by')) {
            $sort_by = $request->input('sort_by');
            switch ($sort_by) {
                case 'new':
                    $query->orderBy('product_id', 'desc');
                    break;
                case 'old':
                    $query->orderBy('product_id', 'asc');
                    break;
                case 'giam_dan':
                    $query->orderBy('product_price', 'desc');
                    break;
                case 'tang_dan':
                    $query->orderBy('product_price', 'asc');
                    break;
                case 'kytu_az':
                    $query->orderBy('product_name', 'asc');
                    break;
                case 'kytu_za':
                    $query->orderBy('product_name', 'desc');
                    break;
                default:
                    $query->orderBy('product_id', 'desc');
            }
        }

        // Lọc theo giá nếu có
        if ($request->has('start_price') && $request->has('end_price')) {
            $min_prices = $request->input('start_price');
            $max_prices = $request->input('end_price');
            $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc');
        }
        // Lấy dữ liệu sản phẩm và phân trang
        $category_by_id = $query->get();

        return view('pages.category.show_category')
            ->with(compact('category_filter', 'brand_filter', 'category_by_id', 'category_name', 'min_price', 'max_price'));
    }

    public function product_tabs(Request $request)
    {
        $data = $request->all();
        $output = '';
        $product = Product::where('category_id', $data['cate_id'])->orderBy('product_id', 'desc')->limit(6)->get();
        $product_count = $product->count();
        if ($product_count > 0) {
            $output .= '<div class="row product-row-container mt-minus-10">';
            foreach ($product as $val) {
                $output .= '
                    <div class="col-lg-2 col-md-4 col-sm-6 product-content tab-panel fade active show">
                        <div class="productinfo">
                            <a class="img-center">
                                <img class="img-products" src="' . url('/uploads/product/' . $val->product_image) . '" />';
                if ($val->promotional_price > 0) {
                    $output .= ' <span class="header-image-promotional">Khuyến mãi đặc biệt</span>';
                }
                $output .= '</a>
                            <a href="' . url('chi-tiet-san-pham/' . $val->product_id) . '">
                                <p class="product-name">' . $val->product_name . '</p>
                            </a>';
                $output .= '<div class="price-product">';
                if ($val->promotional_price > 0) {
                    $output .= '<div class="price-info">
                                    <div class="price-content1">
                                        <span
                                            class="price-small">' . number_format($val->product_price, 0, ',', '.') . '
                                        </span>
                                            <span class="currency-unit">₫</span>
                                    </div>
                                        <div class="price-content2">
                                            <span class="promotional-price">
                                            ' . number_format($val->promotional_price, 0, ',', '.') . '
                                        </span>
                                            <span class="currency-unit">₫</span>
                                    </div>
                                </div>';
                } else {
                    $output .= '<div class="price-content">
                                    <span class="price">' . number_format($val->product_price, 0, ',', '.') . ' </span>
                                    <span class="currency-unit">₫</span>
                                </div>';
                }
                $output .= '</div>';
                $output .= '<form>
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" class="cart_product_id_' . $val->product_id . '"
                                    value="' . $val->product_id . '">
                                <input type="hidden" class="cart_product_name_' . $val->product_id . '"
                                    value="' . $val->product_name . '">
                                <input type="hidden" class="cart_product_image_' . $val->product_id . '"
                                    value="' . $val->product_image . '">
                                <input type="hidden" class="cart_product_quantity_' . $val->product_id . '"
                                    value="' . $val->product_quantity . '">';
                if ($val->promotional_price > 0) {
                    $output .= '<input type="hidden" class="cart_product_price_' . $val->product_id . '"
                                        value="' . $val->promotional_price . '">';
                } else {
                    $output .= '<input type="hidden" class="cart_product_price_' . $val->product_id . '"
                                        value="' . $val->product_price . '">';
                }
                $output .= '    <input type="hidden" class="cart_category_product_' . $val->product_id . '"
                                    value="' . $val->category->category_name . '">
                                <input type="hidden" class="cart_brand_product_' . $val->product_id . '"
                                    value="' . $val->brand->brand_name . '">
                                <input type="hidden" class="cart_product_qty_' . $val->product_id . '" value="1">

                                <div class="order-button">
                                    <a class="add-to-cart" data-id="' . $val->product_id . '"><i
                                            class="fa-solid fa-cart-arrow-down"></i>Đặt hàng
                                    </a>
                                </div>
                            </form>';
                $output .= '
                        </div>
                    </div>';
            }
            $output .= '
            <div class="view-all">
                <a href="' . url('danh-muc-san-pham/' . $val->category_id) . '">Xem tất cả</a>
            </div>';
        }
        echo $output;
    }
}
