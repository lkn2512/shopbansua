<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPost;
use App\Models\Post;

class PostController extends Controller
{
    public function danh_muc_bai_viet($cate_post_slug)
    {
        $category_post = CategoryPost::orderBy('cate_post_name', 'asc')->where('cate_post_status', '1')->get();

        $catepost = CategoryPost::where('cate_post_slug', $cate_post_slug)->take(1)->get();
        foreach ($catepost as $key => $cate) {
            $cate_id = $cate->cate_post_id;
        }
        if ($catepost->isEmpty()) {
            abort(404);
        }
        $post = Post::where('post_status', '1')->where('cate_post_id', $cate_id)->orderBy('post_id', 'desc')->paginate(10);
        return view('pages.post.category_post')->with(compact('category_post', 'cate_id', 'post', 'catepost'));
    }

    public function bai_viet(Request $request, $post_slug)
    {
        $post = Post::where('post_slug', $post_slug)->first();
        if (!$post) {
            abort(404);
        }
        $cate_post_id = $post->cate_post_id;
        // Lấy thông tin danh mục bài viết
        $categoryPost = CategoryPost::where('cate_post_id', $cate_post_id)->first();
        $cate_post_name = $categoryPost->cate_post_name;
        // Tăng lượt xem bài viết
        $post->post_view = $post->post_view + 1;
        $post->save();
        // Lấy các bài viết liên quan
        $related_post = Post::with('category_post')
            ->where('cate_post_id', $cate_post_id)
            ->where('post_status', '1')
            ->where('post_id', '!=', $post->post_id)
            ->limit(5)
            ->get();
        return view('pages.post.post')->with(compact('post', 'related_post', 'cate_post_id', 'cate_post_name', 'categoryPost'));
    }

    public function post_footer($cate_post_slug, $post_slug)
    {
        $post_positions = Post::with('category_post')
            ->whereHas('category_post', function ($query) {
                $query->where('cate_post_positions', 2);
            })
            ->where('post_slug', $post_slug)
            ->first();

        return view('pages.footer.post-footer')->with(compact('post_positions'));
    }
    public function post_header($cate_post_slug, $post_slug)
    {
        $post_positions_header = Post::with('category_post')
            ->whereHas('category_post', function ($query) use ($cate_post_slug) {
                $query->where('cate_post_slug', $cate_post_slug)
                    ->where('cate_post_positions', 1);
            })
            ->where('post_slug', $post_slug)
            ->first();
        return view('pages.header.post-header', compact('post_positions_header'));
    }
}
