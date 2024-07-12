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
        // Lấy danh mục và các thương hiệu có sản phẩm trong danh mục đó
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();

        // Lấy danh sách thương hiệu có sản phẩm trong danh mục đã chọn
        $brand = Brand::whereHas('product', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        // Lấy giá sản phẩm tối thiểu và tối đa
        $min_price = Product::where('category_id', $category_id)->min('product_price');
        $max_price = Product::where('category_id', $category_id)->max('product_price');

        // Lấy tên danh mục
        $category_name = CategoryProduct::where('category_id', $category_id)->limit(1)->get();

        // Bắt đầu query để lấy sản phẩm
        $query = Product::where('category_id', $category_id)
            ->where('product_status', '1')
            ->where('product_condition', '1');

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
        $category_by_id = $query->paginate(20);

        return view('pages.category.show_category')
            ->with(compact('category', 'brand', 'category_by_id', 'category_name', 'min_price', 'max_price'));
    }


    public function product_tabs(Request $request)
    {
        $data = $request->all();
        $output = '';
        $product = Product::where('category_id', $data['cate_id'])->orderBy('product_id', 'desc')->limit(6)->get();
        $product_count = $product->count();
        if ($product_count > 0) {
            $output .= '<div class="row row-content">';
            foreach ($product as $val) {
                $output .= '
                    <div class="col-md-2 tab-panel fade active show">
                    <div class="col-border">
                            <div class="mb-5">
                                <div class="productinfo">
                                    <form>
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
                $output .= ' </div>
                                    </form>
                                </div>
                            </div>
                         </div>
                    </div>
                ';
            }
            $output .= '<div class="view-all">
                <a href="' . url('danh-muc-san-pham/' . $val->category_id) . '">Xem tất cả</a>
            </div>';
            $output .= '</div>';
        }

        echo $output;
    }
}
