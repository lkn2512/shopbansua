<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryPost;
use App\Models\Post;
use Brian2694\Toastr\Facades\Toastr;

class PostController extends Controller
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
    public function add_post()
    {
        $this->AuthLogin();
        $cate_post = CategoryPost::orderBy('cate_post_name', 'asc')->get();
        return view('admin.post.add_post')->with(compact('cate_post'));
    }
    public function save_post(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_status = $data['post_status'];
        $post->cate_post_id = $data['cate_post_id'];

        $get_image = $request->file('post_image');

        if ($get_image) {
            // Lấy tên gốc của hình ảnh
            $get_name_image = $get_image->getClientOriginalName();
            // Lấy tên file không bao gồm phần mở rộng
            $name_image = pathinfo($get_name_image, PATHINFO_FILENAME);
            // Tạo tên mới cho file hình ảnh
            $new_image = $name_image . '_' . time() . '.' . $get_image->getClientOriginalExtension();
            // Di chuyển file hình ảnh vào thư mục public/uploads/post
            $get_image->move(public_path('uploads/post'), $new_image);
            $post->post_image = $new_image;
        }
        $post->save();
        Toastr::success('Thêm tin tức thành công!', 'Thành công');
        return redirect()->back();
    }
    public function list_post()
    {
        $this->AuthLogin();
        $cate_post = DB::table('tbl_posts')->orderBy('cate_post_id', 'asc')->get();
        $all_post = Post::orderBy('post_id', 'desc')
            ->join('tbl_category_post', 'tbl_category_post.cate_post_id', '=', 'tbl_posts.cate_post_id')
            ->get();
        $post = Post::get();
        $count_post = $post->count();
        return view('admin.post.list_post')->with(compact('all_post', 'count_post'));
    }

    public function unactive_post($post_id)
    {
        $this->AuthLogin();
        Post::where('post_id', $post_id)->update(['post_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_post($post_id)
    {
        $this->AuthLogin();
        Post::where('post_id', $post_id)->update(['post_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }

    public function edit_post($post_id)
    {
        $this->AuthLogin();
        $cate_post =  CategoryPost::orderBy('cate_post_name', 'asc')->get();
        $edit_post = Post::where('post_id', $post_id)->get();
        return view('admin.post/edit_post')->with(compact('cate_post', 'edit_post'));
    }
    public function update_post(Request $request, $post_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $post = Post::find($post_id);
        $post->post_title = $data['post_title'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_status = $data['post_status'];
        $post->cate_post_id = $data['cate_post_id'];

        $get_image = $request->file('post_image');
        if ($get_image) {
            if ($post->post_image && file_exists(public_path('uploads/post/' . $post->post_image))) {
                unlink(public_path('uploads/post/' . $post->post_image));
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path('/uploads/post'), $new_image);
            $post->post_image = $new_image;
        }
        $post->save();
        Toastr::success('Đã cập nhật các thay đổi!', 'Thành công');
        return redirect()->back();
    }
    public function delete_post($post_id)
    {
        $this->AuthLogin();
        try {
            $post = Post::find($post_id);
            if ($post) {
                $post_img = $post->post_image;
                if ($post_img && file_exists(public_path('uploads/post/' . $post_img))) {
                    unlink(public_path('uploads/post/' . $post_img));
                }
                $post->delete();
                return response()->json(['status' => 'success', 'message' => 'Một tin tức đã bị xoá.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Tin tức không tồn tại']);
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá tin tức.', 'error' => $e->getMessage()]);
        }
    }
}
