<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
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
    public function list_comment()
    {
        $this->AuthLogin();
        $comment = Comment::with('product')->orderBy('comment_id', 'desc')->where('comment_parent_comment', '0')->get();
        $comment_reply = Comment::with('product')->orderBy('comment_id', 'asc')->where('comment_parent_comment', '>', '0')->get();

        $all_comment_customer = Comment::with('product')->orderBy('comment_id', 'desc')->where('comment_parent_comment', '0')->get();
        $count_comment = $all_comment_customer->count();
        return view('admin.comment.list_comment')->with(compact('comment', 'comment_reply', 'count_comment'));
    }
    public function reply_comment(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $comment = new Comment();
        $comment->comment_name = 'KN-MILK';
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->customer_id = 0;
        $comment->save();
    }
    public function delete_comment($comment_id)
    {
        $this->AuthLogin();
        try {
            $comment = Comment::where('comment_id', $comment_id);
            $comment_reply = Comment::where('comment_parent_comment', $comment_id);
            foreach ($comment_reply as $com_rep) {
                $getID_comment_reply = $com_rep->comment_id;
                $comment_reply = Comment::find($getID_comment_reply);
            }
            $comment_reply->delete();
            $comment->delete();
            return response()->json(['status' => 'success', 'message' => 'Một bình luận của khách hàng đã bị xoá']);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá bình luận.', 'error' => $e->getMessage()]);
        }
    }
    public function delete_comment_admin($comment_id)
    {
        $this->AuthLogin();
        $comment = Comment::where('comment_id', $comment_id);
        $comment->delete();
        return response()->json(['status' => 'success', 'message' => 'Bình luận của bạn đã bị xoá']);
    }
}
