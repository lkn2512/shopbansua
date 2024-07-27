<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Section;
use Brian2694\Toastr\Facades\Toastr;

class SectionController extends Controller
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
    public function all_section_product()
    {
        $this->AuthLogin();
        $section_product = Section::orderBy('section_name', 'asc')->get();

        $product_counts = [];
        foreach ($section_product as $value) {
            $section_id = $value->section_id;
            $product_counts[$section_id] = Product::where('section_id', $section_id)->count();
        }
        $count_allSectionProduct = $section_product->count();

        return view('admin.section.list-section')->with(compact('section_product', 'product_counts', 'count_allSectionProduct'));
    }
    public function unactive_section_product($section_id)
    {
        $this->AuthLogin();
        Section::where('section_id', $section_id)->update(['section_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Chuyên mục đã được ẩn.']);
    }

    public function active_section_product($section_id)
    {
        $this->AuthLogin();
        Section::where('section_id', $section_id)->update(['section_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Chuyên mục đã được hiển thị.']);
    }
    public function add_section_product()
    {
        $this->AuthLogin();
        $section_product = Section::orderBy('section_name', 'asc')->get();
        return view('admin.section.add-section')->with(compact('section_product'));
    }
    public function save_section_product(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $existing = Section::where('section_name', $data['section_name'])->first();
        if ($existing) {
            return response()->json(['error' => 'Chuyên mục sản phẩm đã tồn tại.']);
        } else {
            $section = new Section();
            $section->section_name = $data['section_name'];
            $section->section_description = $data['section_desc'];
            $section->section_status = $data['section_status'];
            $section->section_slug = $data['section_slug'];
            $section->save();
            return response()->json(['success' => 'Thêm chuyên mục sản phẩm thành công.']);
        }
    }
    public function edit_section_product($section_id)
    {
        $this->AuthLogin();
        $section_product = Section::orderBy('Section_name', 'asc')->get();
        $edit_section_product = Section::where('section_id', $section_id)->get();
        return view('admin.section.edit-section')->with(compact('edit_section_product', 'section_product'));
    }
    public function update_section_product(Request $request, $section_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $existing = Section::where('section_name', $data['section_product_name'])->where('section_id', '!=', $section_id)->exists();;
        if ($existing) {
            return response()->json(['error' => 'Chuyên mục sản phẩm đã tồn tại.']);
        } else {
            $section_product = Section::find($section_id);
            $section_product->section_name = $data['section_product_name'];
            $section_product->section_description = $data['section_product_desc'];
            $section_product->section_status = $data['section_product_status'];
            $section_product->section_slug = $data['section_slug'];
            $section_product->save();
            return response()->json(['success' => 'Đã cập nhật thay đổi.']);
        }
    }
    public function delete_section_product($section_id)
    {
        $this->AuthLogin();
        $productCount = Product::where('section_id', $section_id)->count();
        if ($productCount > 0) {
            return response()->json(['status' => 'info', 'message' => 'Không thể xoá chuyên mục này vì có sản phẩm liên quan!']);
        } else {
            Section::where('section_id', $section_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một chuyên mục đã bị xoá']);
        }
    }
}
