<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Visitors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
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
    public function index()
    {
        return view('admin_login');
    }

    public function admin_check(Request $request)
    {
        $user_email = $request->input('admin_email');
        $user_password = $request->input('admin_password');

        $result = User::where('email', $user_email)->first();

        if ($result && Hash::check($user_password, $result->password)) {
            Session::put('user_name', $result->name);
            Session::put('user_id', $result->id);
            return Redirect::to('Admin/dashboard');
        } else {
            Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
            return view('admin_login');
        }
    }
    public function show_dashboard(Request $request)
    {
        Log::info('Reached show_dashboard method');
        $this->AuthLogin();
        $user_ip_address = $request->ip();
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $one_years = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $visitor_of_lastmonth = Visitors::whereBetween('date_visitors', [$early_last_month, $end_of_last_month])->get();
        $visitor_lastmonth_count = $visitor_of_lastmonth->count();

        $visitor_of_thismonth = Visitors::whereBetween('date_visitors', [$early_this_month, $now])->get();
        $visitor_thismonth_count = $visitor_of_thismonth->count();

        $visitor_year = Visitors::whereBetween('date_visitors', [$one_years, $now])->get();
        $visitor_year_count = $visitor_year->count();

        $visitors_current = Visitors::where('ip_address', $user_ip_address)->get();
        $visitors_count = $visitors_current->count();

        $visitors = Visitors::all();
        $visitors_total = $visitors->count();

        if ($visitors_count < 1) {
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitors = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }
        //total
        $product_count = Product::all()->count();
        $product_views = Product::orderBy('product_view', 'DESC')->take(10)->get();
        $post_count = Post::all()->count();
        $post_views = Post::orderBy('post_view', 'DESC')->whereNotIn('cate_post_id', [36])->whereNotIn('cate_post_id', [37])->take(10)->get();
        $order_count = Order::all()->count();
        $customer_count = Customer::all()->count();

        $id = Session::get('user_id');
        if ($id) {
            $get_user = User::where('id', $id)->get();
        }

        $notification = Notification::where('read', 0)->get();
        $notifications_count = $notification->count();

        $notifications_order = Notification::where('read', 0)->where('message', 'Đơn hàng mới')->get();
        $notifications_order_count = $notifications_order->count();

        $notifications_contact = Notification::where('read', 0)->where('message', 'Tin nhắn mới')->get();
        $notifications_contact_count = $notifications_contact->count();

        return view('admin.dashboard')->with(compact('visitors_total', 'visitors_count', 'visitor_lastmonth_count', 'visitor_thismonth_count', 'visitor_year_count', 'product_count', 'post_count', 'order_count', 'customer_count', 'product_views', 'post_views', 'get_user', 'notifications_order_count', 'notifications_contact_count'));
    }

    public function logout_admin()
    {
        $this->AuthLogin();
        Session::put('user_name', null);
        Session::put('user_id', null);
        return Redirect::to('/Admin/admin-login');
    }
    public function filter_by_date(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistic::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'asc')->get();
        foreach ($get as $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function dashboard_filter(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $dau_thangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {
            $get = Statistic::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'asc')->get();
        } elseif ($data['dashboard_value'] == 'thangtruoc') {
            $get = Statistic::whereBetween('order_date', [$dau_thangtruoc, $cuoi_thangtruoc])->orderBy('order_date', 'asc')->get();
        } elseif ($data['dashboard_value'] == 'thangnay') {
            $get = Statistic::whereBetween('order_date', [$dau_thangnay, $now])->orderBy('order_date', 'asc')->get();
        } elseif ($data['dashboard_value'] == '365ngayqua') {
            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'asc')->get();
        }
        foreach ($get as $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }

        echo $data = json_encode($chart_data);
    }
    public function days_order_default()
    {
        $this->AuthLogin();
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'asc')->get();
        foreach ($get as $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }
}
