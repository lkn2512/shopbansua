<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryProduct;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;

class CategoryProductController extends Controller
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
    public function add_category_product()
    {
        $this->AuthLogin();
        $category_product = CategoryProduct::orderBy('category_name', 'asc')->get();
        return view('admin.category.add_category_product')->with(compact('category_product'));
    }

    public function all_category_product()
    {
        $this->AuthLogin();
        $category_product = CategoryProduct::orderBy('category_name', 'asc')->get();

        $product_counts = [];
        foreach ($category_product as $value) {
            $category_id = $value->category_id;
            $product_counts[$category_id] = Product::where('category_id', $category_id)->count();
        }
        $count_allCategoryProduct = $category_product->count();

        return view('admin.category.all_category_product')->with(compact('category_product', 'count_allCategoryProduct', 'product_counts'));
    }

    public function save_category_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $category_product = new CategoryProduct();
        $category_product->category_name = $data['category_product_name'];
        $category_product->category_desc = $data['category_product_desc'];
        $category_product->category_status = $data['category_product_status'];
        $category_product->save();
        Toastr::success('Thêm danh mục sản phẩm thành công', 'Thành công');
        return Redirect::to('Admin/add-category-product');
    }

    public function unactive_category_product($category_id)
    {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_id)->update(['category_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục sản phẩm đã được ẩn.']);
    }

    public function active_category_product($category_id)
    {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_id)->update(['category_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục sản phẩm đã được hiển thị.']);
    }

    public function edit_category_product($category_id)
    {
        $this->AuthLogin();
        $category_product = CategoryProduct::orderBy('category_name', 'asc')->get();
        $edit_category_product = CategoryProduct::where('category_id', $category_id)->get();
        return view('admin.category.edit_category_product')->with(compact('edit_category_product', 'category_product'));
    }
    public function update_category_product(Request $request, $category_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $category_product = CategoryProduct::find($category_id);
        $category_product->category_name = $data['category_product_name'];
        $category_product->category_desc = $data['category_product_desc'];
        $category_product->category_status = $data['category_product_status'];
        $category_product->save();
        Toastr::success('Đã cập nhật thay đổi!', 'Thành công');
        return redirect()->back();
    }
    public function delete_category_product($category_id)
    {
        $this->AuthLogin();
        $productCount = Product::where('category_id', $category_id)->count();
        if ($productCount > 0) {
            return response()->json(['status' => 'info', 'message' => 'Không thể xoá danh mục này vì có sản phẩm liên quan!']);
        } else {
            CategoryProduct::where('category_id', $category_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một danh mục sản phẩm đã bị xoá']);
        }
    }
}
