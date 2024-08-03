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

            if ($viewName !== 'pages.category.show_category' && $viewName !== 'pages.product-all.all_product_new' &&  $viewName !== 'pages.product-all.all-product-selling' && $viewName !== 'pages.product-all.all-product-featured' && $viewName !== 'pages.product-all.all-product-view' && $viewName !== 'pages.section.show-section' && $viewName !== 'pages.brand.brand-product') {
                $min_price = '';
                $max_price = '';
                $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();
                $brand = Brand::where('brand_status', '1')->orderBy('brand_name', 'asc')->get();
                $view->with(compact('min_price', 'max_price', 'category', 'brand'));
            }
            $contact_footer = Information::get();

            $category_post_default = CategoryPost::orderBy('cate_post_name', 'asc')->where('cate_post_status', '1')->where('cate_post_positions', '0')->get();

            //Bai viet header
            $category_post_header = CategoryPost::orderBy('cate_post_name', 'asc')
                ->where('cate_post_positions', '1')
                ->where('cate_post_status', '1')
                ->get();

            $post_header = [];
            foreach ($category_post_header as $category) {
                // Lấy bài viết đầu tiên trong danh mục này
                $post = Post::where('post_status', 1)
                    ->where('cate_post_id', $category->cate_post_id)
                    ->first();

                if ($post) {
                    $post_header[] = [
                        'cate_post_slug' => $category->cate_post_slug,
                        'cate_post_name' => $category->cate_post_name,
                        'post_slug' => $post->post_slug,
                    ];
                }
            }
            //Bai viet footer
            $category_post_footer = CategoryPost::orderBy('cate_post_name', 'asc')->where('cate_post_positions', '2')->where('cate_post_status', '1')->get();
            $post_footer = [];
            foreach ($category_post_footer as $category) {
                $posts = Post::with('category_post')->where('post_status', 1)->where('cate_post_id', $category->cate_post_id)->get();
                $post_footer[$category->cate_post_slug] = $posts;
            }
            $customer_id = Session::get('customer_id');
            if ($customer_id) {
                $customer = Customer::where('customer_id', $customer_id)->get();
            } else {
                $customer = '';
            }

            $sections = Section::where('section_status', 1)->orderBy('section_name', 'asc')->get();

            $view->with(compact('contact_footer', 'post_footer', 'category_post_default', 'category_post_header', 'post_header', 'category_post_footer', 'customer', 'sections'));
        });
    }
}
