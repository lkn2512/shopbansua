<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\ContactCustomer;
use App\Models\Customer;
use App\Models\Information;
use App\Models\Notification;
use Brian2694\Toastr\Facades\Toastr;

class ContactController extends Controller
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

    public function information()
    {
        $this->AuthLogin();
        $contact = Information::get();
        return view('admin.information.add_information')->with(compact('contact'));
    }
    public function logo_home()
    {
        $this->AuthLogin();
        $contact = Information::get();
        return view('admin.information.logo_website')->with(compact('contact'));
    }

    public function update_info(Request $request, $info_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $contact = Information::find($info_id);

        if ($data['info_note']) {
            $contact->info_note = $data['info_note'];
        } else {
            $contact->info_note = '';
        }
        $contact->info_map = $data['info_map'];
        $contact->info_email = $data['info_email'];
        $contact->info_address = $data['info_address'];
        $contact->info_phone = $data['info_phone'];

        $fanpageUrl = $data['info_fanpage_url'];
        $embedCode = '<div id="fb-root"></div>
                  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v19.0" nonce="kEGgQTNY"></script>
                  <div class="fb-page" data-href="' . $fanpageUrl . '" data-tabs="message" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="' . $fanpageUrl . '" class="fb-xfbml-parse-ignore"><a href="' . $fanpageUrl . '">Kn-Milk</a></blockquote></div>';
        $contact->info_fanpage_url = $fanpageUrl;
        $contact->info_fanpage = $embedCode;
        $contact->update();
        Toastr::success('Đã cập nhật các thay đổi!');
        return redirect()->back();
    }
    public function  update_info_logo(Request $request, $info_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $contact = Information::find($info_id);
        $contact->slogan_image = $data['slogan_image'];
        $get_image = $request->file('info_image');
        $path = 'public/uploads/contact/';
        if ($get_image) {
            unlink($path . $contact->info_image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            $contact->info_image = $new_image;
        }
        $contact->update();
        Toastr::success('Đã cập nhật các thay đổi!');
        return redirect()->back();
    }

    public function all_message()
    {
        $this->AuthLogin();
        $contact = ContactCustomer::with('notification')->orderBy('created_at', 'desc')->paginate(20);
        $all_contact = ContactCustomer::get();
        $count_contact = $contact->count();

        return view('admin.contact.all-message')->with(compact('contact', 'count_contact'));
    }
    public function search_contact(Request $request)
    {
        $this->AuthLogin();
        $keyword = $request->input('keyword');
        $contact = ContactCustomer::orderBy('created_at', 'desc')
            ->where('contact_name', 'LIKE', "%$keyword%")
            ->orWhere('contact_message', 'LIKE', "%$keyword%")
            ->orWhere('created_at', 'LIKE', "%$keyword%")
            ->paginate(20);
        $all_contact = ContactCustomer::get();
        $count_contact = $contact->count();
        return view('admin.contact.all-message')->with(compact('contact', 'count_contact'));
    }
    public function view_contact($contact_id)
    {
        $this->AuthLogin();
        $notification = Notification::where('read', 0)->where('contact_id', $contact_id)->where('message', 'Tin nhắn mới')->first();
        if ($notification) {
            $notification->read = 1;
            $notification->save();
        }
        $contact = ContactCustomer::where('contact_id', $contact_id)->first();
        $get_customer_id = $contact->customer_id;
        $customer = Customer::where('customer_id', $get_customer_id)->get();
        return view('admin.contact.view-message')->with(compact('contact', 'customer'));
    }
    public function delete_contact($contact_id)
    {
        $this->AuthLogin();
        try {
            Notification::where('contact_id', $contact_id)->delete();
            ContactCustomer::where('contact_id', $contact_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Một tin nhắn đã bị xoá']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi bất định']);
        }
    }
}
