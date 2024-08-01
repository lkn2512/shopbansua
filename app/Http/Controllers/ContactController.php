<?php

namespace App\Http\Controllers;

use App\Models\ContactCustomer;
use App\Models\Customer;
use App\Models\Information;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

session_start();

class ContactController extends Controller
{
    public function lien_he()
    {
        $contact = Information::get();
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $customer = Customer::where('customer_id', $customer_id);
        } else {
            return redirect()->to('login')->with('message', 'Vui lòng đăng nhập để gửi liên hệ.');
        }
        return view('pages.contact.contact')->with(compact('contact', 'customer'));
    }
    public function send_contact_customer(Request $request)
    {
        $customer_id = Session::get('customer_id');

        if (!$customer_id) {
            return redirect()->to('login')->with('message', 'Vui lòng đăng nhập để gửi liên hệ.');
        } else {
            $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|max:50',
                'subject' => '',
                'message' => 'required',
            ]);

            try {
                $contact_customer = new ContactCustomer();
                $contact_customer->customer_id = $customer_id;
                $contact_customer->contact_name = $request->input('name');
                $contact_customer->contact_email = $request->input('email');
                $contact_customer->contact_subject = $request->input('subject');
                $contact_customer->contact_message = $request->input('message');
                $contact_customer->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $contact_customer->save();

                $notification = new Notification();
                $notification->contact_id = $contact_customer->contact_id;
                $notification->message = 'Tin nhắn mới';
                $notification->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $notification->save();

                return redirect()->back()->with('message', 'Tin nhắn của bạn đã được gửi đi thành công!');
            } catch (\Exception $e) {
                return redirect()->back()->with('message', 'Đã xảy ra lỗi khi gửi tin nhắn của bạn. Vui lòng thử lại sau.');
            }
        }
    }
}
