<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\CategoryProduct;

session_start();

class BrandProduct extends Controller
{
    public function show_brand_home($brand_id)
    {
        $cate_product = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $brand_product = Brand::where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        $brand_by_id = DB::table('tbl_product')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('tbl_product.brand_id', $brand_id)
            ->get();

        $brand_name = Brand::where('tbl_brand.brand_id', $brand_id)->limit(1)->get();
        return view('pages.brand.show_brand')
            ->with('category', $cate_product)->with('brand', $brand_product)->with('brand_by_id', $brand_by_id)->with('brand_name', $brand_name);
    }
}
