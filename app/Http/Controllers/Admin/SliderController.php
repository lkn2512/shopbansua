<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Slider;
use Brian2694\Toastr\Facades\Toastr;

class SliderController extends Controller
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
    public function manage_slider()
    {
        $this->AuthLogin();
        $all_slider = Slider::with('product')->orderByDesc('slider_id')->get();
        $count_slider = $all_slider->count();
        return view('admin.slider.list_slider')->with(compact('all_slider', 'count_slider'));
    }

    public function add_slider()
    {
        $this->AuthLogin();
        $slider = Slider::orderBy('slider_id', 'desc')->get();
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('admin.slider.add_slider')->with(compact('slider', 'products'));
    }
    public function insert_slider(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $get_image = $request->file('slider_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path('/uploads/slider'), $new_image);

            $slider = new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->product_id = $data['product_id'];
            $slider->save();
            Toastr::success('Thêm một banner thành công!', 'Thành công');
        } else {
            return redirect()->back()->with('error_alert', 'Hình ảnh là bắt buộc!');
        }
        return Redirect::to('Admin/add-slider');
    }

    public function unactive_slide($slider_id)
    {
        $this->AuthLogin();
        Slider::where('slider_id', $slider_id)->update(['slider_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_slide($slider_id)
    {
        $this->AuthLogin();
        Slider::where('slider_id', $slider_id)->update(['slider_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }

    public function edit_slide($slider_id)
    {
        $this->AuthLogin();
        $edit_slider = Slider::with('product')->where('slider_id', $slider_id)->get();
        $slider = Slider::orderBy('slider_id', 'desc')->get();
        $products = Product::orderBy('product_name', 'asc')->get();
        return view('admin.slider.edit_slider')->with(compact('edit_slider', 'slider', 'products'));
    }
    public function update_slide(Request $request, $slider_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $slider = Slider::find($slider_id);
        $slider->slider_name = $data['slider_name'];
        $slider->slider_status = $data['slider_status'];
        $slider->slider_desc = $data['slider_desc'];
        $slider->product_id = $data['product_id'];
        $get_image = $request->file('slider_image');
        if ($get_image) {
            if ($slider->slider_image && file_exists(public_path('uploads/slider/' . $slider->slider_image))) {
                unlink(public_path('uploads/slider/' . $slider->slider_image));
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path('/uploads/slider'), $new_image);

            $slider->slider_image = $new_image;
        }
        $slider->save();
        Toastr::success('Đã cập nhật các thay đổi!', 'Thành công');
        return redirect()->back();
    }

    public function delete_slider($slider_id)
    {
        $this->AuthLogin();
        try {
            $slider = Slider::find($slider_id);
            if (!$slider) {
                return response()->json(['status' => 'error', 'message' => 'Banner không tồn tại.']);
            }
            $slider_img = $slider->slider_image;

            if ($slider_img && file_exists(public_path('uploads/slider/' . $slider_img))) {
                unlink(public_path('uploads/slider/' . $slider_img));
            }
            $slider->delete();
            return response()->json(['status' => 'success', 'message' => 'Một banner đã bị xoá.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá banner.', 'error' => $e->getMessage()]);
        }
    }
}
