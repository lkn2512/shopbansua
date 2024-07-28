<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Video;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\URL;

class VideoController extends Controller
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
    public function show_video()
    {
        $this->AuthLogin();
        $video = Video::orderBy('video_id', 'desc')->get();
        $video_count = $video->count();
        return view('admin.video.list-video')->with(compact('video', 'video_count'));
    }
    public function add_video()
    {
        $this->AuthLogin();
        $video = Video::orderBy('video_id', 'desc')->get();
        $video_count = $video->count();
        return view('admin.video.add-video')->with(compact('video', 'video_count'));
    }
    public function save_video(Request $request)
    {
        $this->AuthLogin();
        try {
            $data = $request->all();
            $video = new Video();
            $sub_link = substr($data['video_link'], 17); //cắt link để lấy mã của link

            $video->video_title = $data['video_title'];
            $video->video_slug = $data['video_slug'];
            $video->video_link = $data['video_link'];
            $video->video_code_link = $sub_link;
            $video->video_iframe =  '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . $sub_link . '"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
            $video->video_description = $data['video_description'];
            $video->video_status = 1;
            $video->save();
            return response()->json(['success' => 'Thêm video thành công.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Lỗi bất định, vui lòng tải lại trang!']);
        }
    }
    public function unactive_video($video_id)
    {
        $this->AuthLogin();
        Video::where('video_id', $video_id)->update(['video_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_video($video_id)
    {
        $this->AuthLogin();
        Video::where('video_id', $video_id)->update(['video_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }
    public function edit_video($video_id)
    {
        $edit_video = Video::where('video_id', $video_id)->get();
        return view('admin.video.edit-video')->with(compact('edit_video'));
    }
    public function update_video(Request $request, $video_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $sub_link = substr($data['video_link'], 17); //cắt link để lấy mã của link

        $video = Video::find($video_id);
        $video->video_title = $data['video_title'];
        $video->video_slug = $data['video_slug'];
        $video->video_link = $data['video_link'];
        $video->video_code_link = $sub_link;

        $newIframeVideo = null;

        $video->video_iframe =  '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . $sub_link . '"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
        $video->video_description = $data['video_description'];
        $video->save();

        $newIframeVideo = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . $sub_link . '"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';

        return response()->json([
            'success' => 'Đã cập nhật thay đổi.',
            'id' => $video_id,
            'newIframeVideo' => $newIframeVideo
        ]);
    }
    public function delete_video($video_id)
    {
        $this->AuthLogin();
        try {
            $video = Video::find($video_id);
            if (!$video) {
                return response()->json(['status' => 'error', 'message' => 'Video không tồn tại.']);
            } else {
                Product::where('video_id', $video_id)->update(['video_id' => NULL]);
                $video->delete();
                return response()->json(['status' => 'success', 'message' => 'Một video đã bị xoá']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá video.', 'error' => $e->getMessage()]);
        }
    }
}
