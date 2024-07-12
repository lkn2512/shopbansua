<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginCustomerController extends Controller
{
    public function forgot_password()
    {
        return view('');
    }
    public function login_customer_google()
    {
    }
    public function login()
    {
        return view('pages.account-customer.sign-in');
    }
    public function register()
    {
        return view('pages.account-customer.sign-up');
    }
    public function logout()
    {
        Session::flush();
        return Redirect::to('login');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = $request->pass_account;
        $customer = Customer::where('customer_email', $email)->first();

        if ($customer && Hash::check($password, $customer->customer_password)) {
            Session::put('customer_id', $customer->customer_id);
            Session::put('customer_name', $customer->customer_name);
            return Redirect::to('/');
        } else {
            Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
            return Redirect::to('login');
        }
    }
    public function add_customer(Request $request)
    {
        $data = $request->validate(
            [
                'customer_name' => 'required|max:100',
                'customer_email' => 'required|unique:tbl_customers|max:255',
                'customer_phone' => 'required|unique:tbl_customers|max:15',
                'customer_password' => 'required',
            ],
            [
                'customer_email.unique' => 'Email đã tồn tại',
                'customer_phone.unique' => 'Số điện thoại đã tồn tại',
                'customer_phone.max' => 'Số điện thoại không được vượt quá :max số'
            ]
        );
        $customer = new Customer();
        $customer->customer_name = $data['customer_name'];
        $customer->customer_phone = $data['customer_phone'];
        $customer->customer_email = $data['customer_email'];
        $customer->customer_password =  Hash::make($data['customer_password']);
        $customer->save();
        return Redirect::to('login');
    }
}
