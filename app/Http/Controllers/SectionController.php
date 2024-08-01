<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;

class SectionController extends Controller
{
    public function chuyen_muc_san_pham(Request $request, $section_slug)
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();

        $section = Section::where('section_slug', $section_slug)->firstOrFail();
        $categoryIds = Product::where('section_id', $section->section_id)
            ->where('product_status', '1')
            ->where('product_condition', '1')
            ->pluck('category_id')
            ->unique(); // Lấy ra các category_id duy nhất
        $category_filter = CategoryProduct::whereIn('category_id', $categoryIds)
            ->where('category_status', '1')
            ->orderBy('category_name', 'asc')
            ->get();

        $brandIds = Product::where('section_id', $section->section_id)->where('product_status', '1')
            ->where('product_condition', '1')->pluck('brand_id')->unique(); // Lấy ra các brand_id duy nhất
        $brand_filter = Brand::whereIn('brand_id', $brandIds)->where('brand_status', 1)->orderBy('brand_name', 'asc')->get();

        $min_price = Product::where('section_id', $section->section_id)->min('product_price');
        $max_price = Product::where('section_id', $section->section_id)->max('product_price');

        // Bắt đầu query để lấy sản phẩm thuộc section_slug
        $query = Product::with('section')
            ->where('section_id', $section->section_id)
            ->where('product_status', '1')
            ->where('product_condition', '1');

        if (isset($_GET['category'])) {
            $category_ids = explode(',', $_GET['category']);
            $query->whereIn('category_id', $category_ids);
        }
        if (isset($_GET['brand'])) {
            $brand_ids = explode(',', $_GET['brand']);
            $query->whereIn('brand_id', $brand_ids);
        }
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            switch ($sort_by) {
                case 'new':
                    $productSec = $query->orderBy('product_id', 'desc')->paginate(20);
                    break;
                case 'old':
                    $productSec = $query->orderBy('product_id', 'asc')->paginate(20);
                    break;
                case 'giam_dan':
                    $productSec = $query->orderBy('product_price', 'desc')->paginate(20);
                    break;
                case 'tang_dan':
                    $productSec = $query->orderBy('product_price', 'asc')->paginate(20);
                    break;
                case 'kytu_az':
                    $productSec = $query->orderBy('product_name', 'asc')->paginate(20);
                    break;
                case 'kytu_za':
                    $productSec = $query->orderBy('product_name', 'desc')->paginate(20);
                    break;
                default:
                    $productSec = $query->orderBy('product_id', 'desc')->paginate(20);
                    break;
            }
        } elseif (isset($_GET['start_price']) && isset($_GET['end_price'])) {
            $min_prices = $_GET['start_price'];
            $max_prices = $_GET['end_price'];
            $productSec = $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc')->paginate(20);
        } else {
            $productSec = $query->orderBy('product_id', 'desc')->paginate(20);
        }
        $productSec = $query->paginate(20);

        return view('pages.section.show-section')->with(compact('min_price', 'max_price', 'section', 'productSec', 'category_filter', 'brand_filter', 'category'));
    }
}
