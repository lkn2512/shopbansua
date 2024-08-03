<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandProduct extends Controller
{
    public function show_brand_product()
    {
        $brand_product = Brand::with('product')->where('brand_status', 1)->orderBy('brand_name')->get();

        return view('pages.brand.show_brand')->with(compact('brand_product'));
    }
    public function brand_products(Request $request, $brand_slug)
    {
        // Lấy thông tin thương hiệu theo slug
        $brand_product_one = Brand::with('product')->where('brand_slug', $brand_slug)->where('brand_status', 1)->first();

        if (!$brand_product_one) {
            abort(404); // Thương hiệu không tồn tại
        }

        // Bắt đầu query để lấy sản phẩm thuộc thương hiệu
        $query = Product::where('brand_id', $brand_product_one->brand_id)
            ->where('product_status', '1')
            ->where('product_condition', '1');

        // Lấy danh mục có sản phẩm thuộc thương hiệu
        $category_filter = CategoryProduct::whereHas('product', function ($query) use ($brand_product_one) {
            $query->where('brand_id', $brand_product_one->brand_id)
                ->where('product_status', '1');
        })->where('category_status', '1')
            ->orderBy('category_name', 'asc')
            ->get();

        // Lấy giá sản phẩm tối thiểu và tối đa
        $min_price = $query->min('product_price');
        $max_price = $query->max('product_price');

        // Lọc theo danh mục nếu có
        if ($request->has('category')) {
            $category_ids = explode(',', $request->input('category'));
            $query->whereIn('category_id', $category_ids);
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
        $brand_by_slug = $query->paginate(20);

        return view('pages.brand.brand-product', compact('brand_product_one', 'brand_by_slug', 'category_filter', 'min_price', 'max_price'));
    }
}
