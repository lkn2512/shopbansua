<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('user_id');
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('Admin/admin-login')->send();
        }
    }
    public function add_brand_product()
    {
        $this->AuthLogin();
        $list_brand = Brand::orderBy('brand_name', 'asc')->get();
        return view('admin.brand.add_brand_product')->with(compact('list_brand'));
    }

    public function all_brand_product()
    {
        $this->AuthLogin();
        $all_brand_product = Brand::orderBy('brand_name', 'ASC')->get();
        $product_counts = [];
        foreach ($all_brand_product as $value) {
            $brand_id = $value->brand_id;
            $product_counts[$brand_id] = Product::where('brand_id', $brand_id)->count();
        }
        $count_brand = $all_brand_product->count();

        return view('admin.brand.all_brand_product')->with(compact('all_brand_product', 'count_brand', 'product_counts'));
    }
    public function save_brand_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Toastr::success('Thêm thương hiệu thành công!');
        return Redirect::to('Admin/add-brand-product');
    }

    public function unactive_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $brand_product_id)->update(['brand_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        Brand::where('brand_id', $brand_product_id)->update(['brand_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }

    public function edit_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        $edit_brand_product = Brand::where('brand_id', $brand_product_id)->get();
        $list_brand = Brand::orderBy('brand_name', 'asc')->get();
        return view('admin.brand.edit_brand_product')->with(compact('edit_brand_product', 'list_brand'));
    }

    public function update_brand_product(Request $request, $brand_id)
    {
        $this->AuthLogin();
        $data = $request->all();

        $brand = Brand::find($brand_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();
        Toastr::success('Đã cập nhật các thay đổi!');
        return redirect()->back();
    }

    public function delete_brand($brand_id)
    {
        $this->AuthLogin();
        $productCount = Product::where('brand_id', $brand_id)->count();
        if ($productCount > 0) {
            return response()->json(['status' => 'info', 'message' => 'Không thể xoá thương hiệu này vì có sản phẩm liên quan!']);
        } else {
            Brand::where('brand_id', $brand_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một thương hiệu đã bị xoá.']);
        }
    }
}
