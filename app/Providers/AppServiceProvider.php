<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Information;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('admin.*', function ($view) {
            $id = Session::get('user_id');
            if ($id) {
                $get_user = User::where('id', $id)->get();
            } else {
                $get_user = '';
            }
            $product_count = Product::all()->count();
            $product_views = Product::orderBy('product_view', 'DESC')->take(10)->get();
            $post_count = Post::all()->count();
            $post_views = Post::orderBy('post_view', 'DESC')->whereNotIn('cate_post_id', [36])->whereNotIn('cate_post_id', [37])->take(10)->get();
            $order_count = Order::all()->count();
            $customer_count = Customer::all()->count();

            $notification = Notification::where('read', 0)->get();
            $notifications_count  = $notification->count();
            $notifications_order = Notification::where('read', 0)->where('message', 'Đơn hàng mới')->get();
            $notifications_order_count = $notifications_order->count();
            $notifications_contact = Notification::where('read', 0)->where('message', 'Tin nhắn mới')->get();
            $notifications_contact_count = $notifications_contact->count();

            $view->with(compact('product_count', 'order_count', 'customer_count', 'post_views', 'product_views', 'post_count', 'get_user', 'notifications_count', 'notifications_order_count', 'notifications_contact_count'));
        });

        view()->composer('pages.*', function ($view) {
            $viewName = $view->getName();

            if ($viewName !== 'pages.category.show_category' && $viewName !== 'pages.product-all.all_product_new' &&  $viewName !== 'pages.product-all.all-product-selling' && $viewName !== 'pages.product-all.all-product-featured' && $viewName !== 'pages.product-all.all-product-view' && $viewName !== 'pages.section.show-section') {
                $min_price = '';
                $max_price = '';
                $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_name', 'asc')->get();
                $brand = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_name', 'asc')->get();
                $view->with(compact('min_price', 'max_price', 'category', 'brand'));
            }
            $contact_footer = Information::get();

            $category_post_frontend = CategoryPost::orderBy('cate_post_name', 'asc')->where('cate_post_status', '1')->get();
            $post_footerService = Post::where('cate_post_id', 36)->where('post_status', 1)->get();
            $post_footerPolicy = Post::where('cate_post_id', 37)->where('post_status', 1)->get();
            $customer_id = Session::get('customer_id');
            if ($customer_id) {
                $customer = Customer::where('customer_id', $customer_id)->get();
            } else {
                $customer = '';
            }

            $sections = Section::where('section_status', 1)->orderBy('section_name', 'asc')->get();

            $view->with(compact('contact_footer', 'post_footerService', 'post_footerPolicy', 'category_post_frontend', 'customer', 'sections'));
        });
        // view()->composer('admin_layout', function ($view) {
        // });
    }
}
