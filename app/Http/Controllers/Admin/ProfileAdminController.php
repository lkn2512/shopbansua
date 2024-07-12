<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProfileAdminController extends Controller
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
    public function profile($id)
    {
        $this->AuthLogin();
        $admin = User::where('id', $id)->get();
        return view('admin.admin-information.profile')->with(compact('admin'));
    }
    public function update_profile(Request $request, $id)
    {
        $this->AuthLogin();

        $data = $request->all();
        $user = User::find($id);
        $user->phone = $data['phone'];
        $user->birthday = $data['birthday'];
        $user->first_address = $data['first_address'];
        $user->second_address = $data['second_address'];
        $user->save();
        Toastr::success('Đã cập nhật lại thông tin cá nhân', 'Thành công');
        return redirect()->back();
    }
    public function rename_admin(Request $request, $id)
    {
        $this->AuthLogin();
        try {
            $data = $request->all();
            $user = User::find($id);
            $user->name = $data['name'];
            $user->save();
            Toastr::success('Tên của bạn đã được thay đổi.', 'Thành công');
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_alert', 'Lỗi bất định.');
        }
    }
    public function update_avatar_admin(Request $request, $id)
    {
        $this->AuthLogin();
        $get_image = $request->file('file_img');

        if ($get_image) {
            $mime_type = $get_image->getClientMimeType();
            if (strpos($mime_type, 'image') !== false) {
                $user = User::find($id);
                if ($user) {
                    $user_image = $user->avatar;
                    if ($user_image && file_exists(public_path('uploads/user/' . $user_image))) {
                        unlink(public_path('uploads/user/' . $user_image));
                    }
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                    $get_image->move(public_path('uploads/user/'), $new_image);
                    $user->avatar = $new_image;
                    $user->save();
                } else {
                    return Redirect()->back()->with('error_alert', 'Người dùng không tồn tại!');
                }
            } else {
                return Redirect()->back()->with('error_alert', 'Định dạng tập tin không hợp lệ!');
            }
        } else {
            return Redirect()->back()->with('error_alert', 'Không có tệp nào được chọn!');
        }
        Toastr::success('Ảnh đại diện đã được thay đổi!', 'Thành công');
        return Redirect()->back();
    }

    public function security($id)
    {
        $this->AuthLogin();
        $admin = User::where('id', $id)->get();
        return view('admin.admin-information.security')->with(compact('admin'));
    }
    public function change_email_admin(Request $request, $id)
    {
        $this->AuthLogin();
        try {
            $data = $request->all();
            $user = User::find($id);
            $user->email = $data['email'];
            $user->save();
            Toastr::success('Email bạn đã được thay đổi.', 'Thành công');
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_alert', 'Lỗi bất định.');
        }
    }
    public function change_password_admin(Request $request, $id)
    {
        $User = User::find($id);
        if (!Hash::check($request->old_password, $User->password)) {
            return redirect()->back()->with('error_alert', 'Mật khẩu cũ không chính xác.');
        } else {
            $User->password = Hash::make($request->new_password);
            $User->save();
            Toastr::success('Thay đổi mật khẩu thành công!', 'Thành công');
            return redirect()->back();
        }
    }
    public function delete_profile(Request $request, $id)
    {
        $this->AuthLogin();
        $admin = User::where('id', $id)->get();
        return view('admin.admin-information.delete-user')->with(compact('admin'));
    }


    public function delete_user_action(Request $request, $id)
    {
        $this->AuthLogin();
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('Admin/logout-admin');
    }
}
