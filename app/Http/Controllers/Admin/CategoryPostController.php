<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryPostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryPost;
use App\Models\Post;
use Brian2694\Toastr\Facades\Toastr;

class CategoryPostController extends Controller
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
    public function add_category_post()
    {
        $this->AuthLogin();
        $category_post = CategoryPost::orderBy('cate_post_name', 'asc')->get();
        return view('admin.category_post.add_category_post')->with(compact('category_post'));
    }

    public function all_category_post()
    {
        $this->AuthLogin();
        $category_post = CategoryPost::orderBy('cate_post_name', 'asc')->get();
        $countCatePost = $category_post->count();

        $post_counts = [];
        foreach ($category_post as $value) {
            $cate_post_id = $value->cate_post_id;
            $post_counts[$cate_post_id] = Post::where('cate_post_id', $cate_post_id)->count();
        }
        return view('admin.category_post.list_category_post')->with(compact('category_post', 'countCatePost', 'post_counts'));
    }
    public function save_category_post(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $category_post = new CategoryPost();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->save();

        Toastr::success('Thêm danh mục tin tức thành công!');
        return redirect()->back();
    }

    public function unactive_category_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục sản phẩm đã được ẩn.']);
    }

    public function active_category_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục sản phẩm đã được hiển thị.']);
    }
    public function edit_category_post($cate_post_id)
    {
        $this->AuthLogin();
        $category_post = CategoryPost::find($cate_post_id);
        $category_post_edit = CategoryPost::orderBy('cate_post_name', 'asc')->get();
        return view('admin.category_post.edit_category_post')->with(compact('category_post', 'category_post_edit'));
    }
    public function update_category_post(Request $request, $cate_post_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $category_post = CategoryPost::find($cate_post_id);
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->save();
        Toastr::success('Đã cập nhật các thay đổi!');
        return redirect()->back();
    }
    public function delete_category_post($cate_post_id)
    {
        $this->AuthLogin();
        $PostCount = Post::where('cate_post_id', $cate_post_id)->count();
        if ($cate_post_id == 36 || $cate_post_id == 37) {
            return response()->json(['status' => 'warning', 'message' => 'Danh mục này là bắt buộc.']);
        } elseif ($PostCount > 0) {
            return response()->json(['status' => 'info', 'message' => 'Không thể xoá danh mục này vì có tin tức liên quan!']);
        } else {
            CategoryPost::where('cate_post_id', $cate_post_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một danh mục tin tức đã bị xoá']);
        }
    }
}
