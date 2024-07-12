<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\CategoryPost;
use App\Models\Post;

class PostController extends Controller
{
    public function danh_muc_bai_viet($cate_post_id)
    {
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $category_post = CategoryPost::orderBy('cate_post_name', 'asc')->where('cate_post_status', '1')->get();
        $catepost = CategoryPost::where('cate_post_id', $cate_post_id)->take(1)->get();
        foreach ($catepost as $key => $cate) {
            $cate_id = $cate->cate_post_id;
        }
        if ($catepost->isEmpty()) {
            abort(404);
        }
        $post = Post::where('post_status', '1')->where('cate_post_id', $cate_post_id)->orderBy('post_id', 'desc')->paginate(5);
        return view('pages.post.category_post')->with(compact('category', 'category_post', 'cate_id', 'post', 'catepost'));
    }

    public function bai_viet(Request $request, $post_id)
    {
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_name', 'asc')->get();

        $post = Post::where('post_id', $post_id)->get();
        foreach ($post as $val) {
            $cate_post_id = $val->cate_post_id;
        }
        if ($post->isEmpty()) {
            abort(404);
        }
        $categoryPost = CategoryPost::where('cate_post_id', $cate_post_id)->get();
        foreach ($categoryPost as $val) {
            $cate_post_name = $val->cate_post_name;
        }

        $post_view = Post::where('post_id', $post_id)->first();

        $post_view->post_view = $post_view->post_view + 1;
        $post_view->save();

        $related_post = Post::with('category_post')->where('cate_post_id', $cate_post_id)->where('post_status', '1')
            ->whereNotIn('tbl_posts.post_id', [$post_id])->limit(5)->get();
        return view('pages.post.post')->with(compact('post', 'related_post', 'category', 'cate_post_id', 'cate_post_name'));
    }

    public function quy_dinh_chung($post_id)
    {
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_name', 'asc')->get();

        $post_service_footer = Post::where('post_id', $post_id)->get();
        return view('pages.footer.post_footer')->with(compact('post_service_footer', 'category'));
    }
}
