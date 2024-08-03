<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryPost;
use App\Models\Post;

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
        $existing = CategoryPost::where('cate_post_name', $data['cate_post_name'])->first();
        if ($existing) {
            return response()->json(['error' => 'Danh mục bài viết đã tồn tại.']);
        } else {
            $category_post = new CategoryPost();
            $category_post->cate_post_name = $data['cate_post_name'];
            $category_post->cate_post_slug = $data['cate_post_slug'];
            $category_post->cate_post_desc = $data['cate_post_desc'];
            $category_post->cate_post_status = $data['cate_post_status'];
            $category_post->cate_post_positions = $data['cate_post_positions'];
            $category_post->save();
            return response()->json(['success' => 'Thêm danh mục bài viết thành công!']);
        }
    }

    public function unactive_category_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục bài viết đã được ẩn.']);
    }

    public function active_category_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Danh mục bài viết đã được hiển thị.']);
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
        $existing = CategoryPost::where('cate_post_name', $data['cate_post_name'])->where('cate_post_id', '!=', $cate_post_id)->exists();
        if ($existing) {
            return response()->json(['error' => 'Danh mục bài viết đã tồn tại.']);
        } else {
            $category_post = CategoryPost::find($cate_post_id);
            $category_post->cate_post_name = $data['cate_post_name'];
            $category_post->cate_post_slug = $data['cate_post_slug'];
            $category_post->cate_post_desc = $data['cate_post_desc'];
            $category_post->cate_post_status = $data['cate_post_status'];
            $category_post->cate_post_positions = $data['cate_post_positions'];
            $category_post->save();
            return response()->json(['success' => 'Đã cập nhật thay đổi.']);
        }
    }
    public function delete_category_post($cate_post_id)
    {
        $this->AuthLogin();
        $categoryPost = CategoryPost::find($cate_post_id);

        if (!$categoryPost) {
            return response()->json(['status' => 'error', 'message' => 'Danh mục không tồn tại!']);
        }

        if ($categoryPost->cate_post_positions == 1 || $categoryPost->cate_post_positions == 2) {
            return response()->json(['status' => 'info', 'message' => 'Danh mục này là bắt buộc.']);
        }

        $PostCount = Post::where('cate_post_id', $cate_post_id)->count();
        if ($PostCount > 0) {
            return response()->json(['status' => 'info', 'message' => 'Không thể xoá danh mục này vì có bài viết liên quan!']);
        } else {
            CategoryPost::where('cate_post_id', $cate_post_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một danh mục bài viết đã bị xoá']);
        }
    }
}
