<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryPostController as Admin_CategoryPostController;
use App\Http\Controllers\Admin\CategoryProductController as Admin_CategoryProductController;
use App\Http\Controllers\Admin\BrandController as Admin_BrandController;
use App\Http\Controllers\Admin\PostController as Admin_PostController;
use App\Http\Controllers\Admin\SliderController as Admin_SliderController;
use App\Http\Controllers\Admin\ProductController as Admin_ProductController;
use App\Http\Controllers\Admin\ContactController as Admin_ContactController;
use App\Http\Controllers\Admin\CouponController as Admin_CouponController;
use App\Http\Controllers\Admin\OrderController as Admin_OrderController;
use App\Http\Controllers\Admin\CommentController as Admin_CommentController;
use App\Http\Controllers\Admin\CustomerController as Admin_CustomerController;
use App\Http\Controllers\Admin\ProfileAdminController as Admin_ProfileAdminController;
use App\Http\Controllers\Admin\VideoController as Admin_VideoController;
use App\Http\Controllers\Admin\HolidayEventController as Admin_HolidayEventController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginCustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrintPDFController;
use App\Http\Controllers\ProductController;
use UniSharp\LaravelFilemanager\Lfm;

// Route::get('/', function () {
//     return view('layout');
// });
Route::prefix('Admin')->group(function () {

    //dashboard - trang tổng quan
    Route::get('/admin-login', [AdminController::class, 'index']);
    Route::post('/admin-check', [AdminController::class, 'admin_check']);
    Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
    Route::get('/logout-admin', [AdminController::class, 'logout_admin']);
    Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);
    Route::post('/dashboard-filter', [AdminController::class, 'dashboard_filter']);
    Route::post('/days-order-default', [AdminController::class, 'days_order_default']);

    //Profile admin
    Route::get('/profile/{id}', [Admin_ProfileAdminController::class, 'profile']);
    Route::get('/security/{id}', [Admin_ProfileAdminController::class, 'security']);
    Route::get('/delete-profile/{id}', [Admin_ProfileAdminController::class, 'delete_profile']);
    Route::post('/update-profile/{id}', [Admin_ProfileAdminController::class, 'update_profile']);
    Route::post('/rename-admin/{id}', [Admin_ProfileAdminController::class, 'rename_admin']);
    Route::post('/update-avatar-admin/{id}', [Admin_ProfileAdminController::class, 'update_avatar_admin']);
    Route::post('/change-email-admin/{id}', [Admin_ProfileAdminController::class, 'change_email_admin']);
    Route::post('/change-password-admin/{id}', [Admin_ProfileAdminController::class, 'change_password_admin']);
    Route::get('/delete-user-action/{id}', [Admin_ProfileAdminController::class, 'delete_user_action']);

    //Category Product - danh mục(loại sản phẩm)
    Route::get('/all-category-product', [Admin_CategoryProductController::class, 'all_category_product']);
    Route::get('/add-category-product', [Admin_CategoryProductController::class, 'add_category_product']);
    Route::get('/edit-category-product/{category_id}', [Admin_CategoryProductController::class, 'edit_category_product']);
    Route::get('/delete-category-product/{category_id}', [Admin_CategoryProductController::class, 'delete_category_product']);
    Route::get('/filter-category-product', [Admin_CategoryProductController::class, 'filterCategoryProduct']);
    Route::get('/unactive-category-product/{category_id}', [Admin_CategoryProductController::class, 'unactive_category_product']);
    Route::get('/active-category-product/{category_id}', [Admin_CategoryProductController::class, 'active_category_product']);
    Route::post('/save-category-product', [Admin_CategoryProductController::class, 'save_category_product']);
    Route::post('/update-category-product/{category_id}', [Admin_CategoryProductController::class, 'update_category_product']);

    //Category Post - danh mục(loại bài viết - tin tức)
    Route::get('/add-category-post', [Admin_CategoryPostController::class, 'add_category_post']);
    Route::post('/save-category-post', [Admin_CategoryPostController::class, 'save_category_post']);
    Route::get('/all-category-post', [Admin_CategoryPostController::class, 'all_category_post']);
    Route::get('/delete-category-post/{cate_post_id}', [Admin_CategoryPostController::class, 'delete_category_post']);
    Route::get('/edit-category-post/{cate_post_id}', [Admin_CategoryPostController::class, 'edit_category_post']);
    Route::post('/update-category-post/{cate_post_id}', [Admin_CategoryPostController::class, 'update_category_post']);
    Route::get('/unactive-category-post/{cate_post_id}', [Admin_CategoryPostController::class, 'unactive_category_post']);
    Route::get('/active-category-post/{cate_post_id}', [Admin_CategoryPostController::class, 'active_category_post']);

    //Brand Product - thương hiện(nhà sản xuất)
    Route::get('/add-brand-product', [Admin_BrandController::class, 'add_brand_product']);
    Route::get('/edit-brand-product/{brand_product_id}', [Admin_BrandController::class, 'edit_brand_product']);
    Route::get('/delete-brand/{brand_id}', [Admin_BrandController::class, 'delete_brand']);
    Route::get('/all-brand-product', [Admin_BrandController::class, 'all_brand_product']);
    Route::get('/unactive-brand-product/{brand_product_id}', [Admin_BrandController::class, 'unactive_brand_product']);
    Route::get('/active-brand-product/{brand_product_id}', [Admin_BrandController::class, 'active_brand_product']);
    Route::post('/save-brand-product', [Admin_BrandController::class, 'save_brand_product']);
    Route::post('/update-brand-product/{brand_id}', [Admin_BrandController::class, 'update_brand_product']);

    //Banner - Slider
    Route::get('/manage-slider', [Admin_SliderController::class, 'manage_slider']);
    Route::get('/add-slider', [Admin_SliderController::class, 'add_slider']);
    Route::post('/insert-slider', [Admin_SliderController::class, 'insert_slider']);
    Route::get('/edit-slider/{slider_id}', [Admin_SliderController::class, 'edit_slide']);
    Route::post('/update-slider/{slider_id}', [Admin_SliderController::class, 'update_slide']);
    Route::get('/delete-slider/{slider_id}', [Admin_SliderController::class, 'delete_slider']);
    Route::get('/unactive-slide/{slider_id}', [Admin_SliderController::class, 'unactive_slide']);
    Route::get('/active-slide/{slider_id}', [Admin_SliderController::class, 'active_slide']);

    //Post - bài viết(tin tức)
    Route::get('/add-post', [Admin_PostController::class, 'add_post']);
    Route::get('/add-post', [Admin_PostController::class, 'add_post']);
    Route::post('/save-post', [Admin_PostController::class, 'save_post']);
    Route::get('/list-post', [Admin_PostController::class, 'list_post']);
    Route::get('/delete-post/{post_id}', [Admin_PostController::class, 'delete_post']);
    Route::get('/edit-post/{post_id}', [Admin_PostController::class, 'edit_post']);
    Route::post('/update-post/{post_id}', [Admin_PostController::class, 'update_post']);
    Route::get('/unactive-post/{post_id}', [Admin_PostController::class, 'unactive_post']);
    Route::get('/active-post/{post_id}', [Admin_PostController::class, 'active_post']);

    //Product - sản phẩm
    Route::get('/add-product', [Admin_ProductController::class, 'add_product']);
    Route::get('/edit-product/{product_id}', [Admin_ProductController::class, 'edit_product']);
    Route::get('/delete-product/{product_id}', [Admin_ProductController::class, 'delete_product']);
    Route::get('/all-product', [Admin_ProductController::class, 'all_product']);
    Route::get('/unactive-product/{product_id}', [Admin_ProductController::class, 'unactive_product']);
    Route::get('/active-product/{product_id}', [Admin_ProductController::class, 'active_product']);
    Route::post('/save-product', [Admin_ProductController::class, 'save_product']);
    Route::post('/update-product/{product_id}', [Admin_ProductController::class, 'update_product']);
    Route::get('add-gallery/{product_id}', [Admin_ProductController::class, 'add_gallery']);
    Route::post('select-gallery', [Admin_ProductController::class, 'select_gallery']);
    Route::post('insert-gallery/{pro_id}', [Admin_ProductController::class, 'insert_gallery']);
    Route::post('update-gallery-name', [Admin_ProductController::class, 'update_gallery_name']);
    Route::post('delete-gallery', [Admin_ProductController::class, 'delete_gallery']);
    Route::post('update-gallery', [Admin_ProductController::class, 'update_gallery']);
    Route::post('/update-img-product', [Admin_ProductController::class, 'update_img_product']);

    Route::post('/uploads-ckeditor', [Admin_ProductController::class, 'ckeditor_image']);
    Route::get('/file-browser', [Admin_ProductController::class, 'file_browser']);

    //Thông tin - infomation
    Route::get('/information', [Admin_ContactController::class, 'information']);
    Route::post('/save-info', [Admin_ContactController::class, 'save_info']);
    Route::post('/update-info/{info_id}', [Admin_ContactController::class, 'update_info']);
    Route::get('/logo-home', [Admin_ContactController::class, 'logo_home']);
    Route::post('/update-info-logo/{info_id}', [Admin_ContactController::class, 'update_info_logo']);

    //Liên hệ của khách hàng - contact 
    Route::get('/all-message', [Admin_ContactController::class, 'all_message']);
    Route::get('/view-contact-customer/{contact_id}', [Admin_ContactController::class, 'view_contact']);
    Route::get('/delete-contact-customer/{contact_id}', [Admin_ContactController::class, 'delete_contact']);
    Route::get('/search-contact-customer', [Admin_ContactController::class, 'search_contact']);

    //sự kiện ngày lễ
    Route::get('/holiday-event', [Admin_HolidayEventController::class, 'list_holidays']);
    Route::get('/holiday-event/create', [Admin_HolidayEventController::class, 'add_holiday_event_page']);
    Route::post('/save-holiday-event', [Admin_HolidayEventController::class, 'save_holiday_event']);
    Route::get('/holiday-event/edit/{holiday_event_id}', [Admin_HolidayEventController::class, 'edit_holiday_event_page']);
    Route::post('/update-holiday-event/{holiday_event_id}', [Admin_HolidayEventController::class, 'update_holiday_event']);
    Route::get('/delete-holiday-event/{holiday_event_id}', [Admin_HolidayEventController::class, 'delete_holiday_event']);
    Route::get('/unactive-holiday-event/{holiday_event_id}', [Admin_HolidayEventController::class, 'unactive_holiday_event']);
    Route::get('/active-holiday-event/{holiday_event_id}', [Admin_HolidayEventController::class, 'active_holiday_event']);

    //coupon - mã giảm giá
    Route::get('/list-coupon', [Admin_CouponController::class, 'list_coupon']);
    Route::get('/insert-coupon', [Admin_CouponController::class, 'insert_coupon']);
    Route::post('/insert-coupon-code', [Admin_CouponController::class, 'insert_coupon_code']);
    Route::get('/edit-coupon/{coupon_id}', [Admin_CouponController::class, 'edit_coupon']);
    Route::post('/update-coupon/{coupon_id}', [Admin_CouponController::class, 'update_coupon']);
    Route::get('/delete-coupon/{coupon_id}', [Admin_CouponController::class, 'delete_coupon']);
    Route::get('/active-coupon/{coupon_id}', [Admin_CouponController::class, 'active_coupon']);
    Route::get('/unactive-coupon/{coupon_id}', [Admin_CouponController::class, 'unactive_coupon']);

    //Order - Đơn đặt hàng của khách hàng
    Route::get('/manage-order', [Admin_OrderController::class, 'manage_order']);
    Route::get('/view-order/{order_code}', [Admin_OrderController::class, 'view_order']);
    Route::post('/update-order-quantity', [Admin_OrderController::class, 'update_order_quantity']);
    Route::post('/update-qty', [Admin_OrderController::class, 'update_qty']);


    //Comment - bình luận sản phẩm
    Route::get('/list-comment', [Admin_CommentController::class, 'list_comment']);
    Route::post('/reply-comment', [Admin_CommentController::class, 'reply_comment']);
    Route::get('/delete-comment/{comment_id}', [Admin_CommentController::class, 'delete_comment']);
    Route::get('/delete-comment-admin/{comment_id}', [Admin_CommentController::class, 'delete_comment_admin']);

    //Customer - khách hàng
    Route::get('/all-customer', [Admin_CustomerController::class, 'all_customer']);
    Route::get('/add-customer', [Admin_CustomerController::class, 'add_customer']);
    Route::post('/save-customer', [Admin_CustomerController::class, 'save_customer']);
    Route::get('/delete-customer/{customer_id}', [Admin_CustomerController::class, 'delete_customer']);
    Route::post('/update-avatar-customer', [Admin_CustomerController::class, 'update_avatar_customer']);
    Route::get('/info-customer/{customer_id}', [Admin_CustomerController::class, 'info_customer']);
    Route::post('/edit-info-customer/{customer_id}', [Admin_CustomerController::class, 'edit_info_customer']);

    //Video
    Route::get('/show-video', [Admin_VideoController::class, 'show_video']);
    Route::post('/select-video', [Admin_VideoController::class, 'select_video']);
    Route::get('/add-video', [Admin_VideoController::class, 'add_video']);
    Route::post('/save-video', [Admin_VideoController::class, 'save_video']);
    Route::get('/edit-video/{video_id}', [Admin_VideoController::class, 'edit_video']);
    Route::post('/update-video/{video_id}', [Admin_VideoController::class, 'update_video']);
    Route::get('/active-video/{video_id}', [Admin_VideoController::class, 'active_video']);
    Route::get('/unactive-video/{video_id}', [Admin_VideoController::class, 'unactive_video']);
    Route::get('/delete-video/{video_id}', [Admin_VideoController::class, 'delete_video']);

    Route::group(['prefix' => '/laravel-filemanager', 'middleware'], function () {
        Lfm::routes();
    });
});





/**************************frontend**************************/

Route::get('/', [HomeController::class, 'index']);
// Route::get('/trang-chu', 'HomeController@index');
Route::get('/lien-he', [ContactController::class, 'lien_he']);
Route::post('/product-tabs', [CategoryProductController::class, 'product_tabs']);

//post
Route::get('/danh-muc-bai-viet/{cate_post_id}', 'App\Http\Controllers\PostController@danh_muc_bai_viet');
Route::get('/bai-viet/{post_id}', 'App\Http\Controllers\PostController@bai_viet');

// all-product-home
Route::get('/all-products-new', 'App\Http\Controllers\HomeController@all_products_new');
Route::get('/all-product-selling', 'App\Http\Controllers\HomeController@all_product_selling');

//search
Route::post('/search-items', 'App\Http\Controllers\HomeController@search_items');
Route::post('/autocomplete-ajax', 'App\Http\Controllers\HomeController@autocomplete_ajax');

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', 'App\Http\Controllers\CategoryproductController@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_id}', 'App\Http\Controllers\BrandProduct@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);

Route::post('/load-comment', [ProductController::class, 'load_comment']);
Route::post('/send-comment', [ProductController::class, 'send_comment']);
Route::post('/recall-comment', [ProductController::class, 'recall_comment']);

//Danh sách yêu thích
Route::post('/favorites-list', 'App\Http\Controllers\FavoritesListController@favorites_list');
Route::post('/add-favorites-list', 'App\Http\Controllers\FavoritesListController@add_favorites_list');
Route::post('/delete-favorite', 'App\Http\Controllers\FavoritesListController@delete_favorite');
Route::post('/deleteAll-favorites', 'App\Http\Controllers\FavoritesListController@deleteAll_favorites');

//bài viết footer
Route::get('/quy-dinh-chung/{post_id}', 'App\Http\Controllers\PostController@quy_dinh_chung');

//cart -  giỏ hàng
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::get('/your-cart', [CartController::class, 'your_cart']);
Route::get('/delete-product-cart/{session_id}', [CartController::class, 'delete_product_cart']);
Route::get('/delete-all-product-cart', [CartController::class, 'delete_all_product_cart']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::get('/show-cart-quantity', [CartController::class, 'show_cart_quantity']);
Route::get('/hover-cart-view', [CartController::class, 'hover_cart_view']);

//coupon -  mã giảm giá
Route::post('/check-coupon', [CheckoutController::class, 'check_coupon']);
Route::get('/remove-coupon', [CheckoutController::class, 'remove_coupon']);

//Đăng nhập - đăng ký
Route::get('/login', [LoginCustomerController::class, 'login']);
Route::post('/login-customer', [LoginCustomerController::class, 'login_customer']);
Route::get('/logout', [LoginCustomerController::class, 'logout']);
Route::get('/register', [LoginCustomerController::class, 'register']);
Route::post('/add-customer', [LoginCustomerController::class, 'add_customer']);

//checkout -  thanh toán
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);
Route::get('/del-fee', [CheckoutController::class, 'del_fee']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);


//địa chỉ hành chính
Route::get('api/get-provinces', [AddressController::class, 'getProvinces']);
Route::get('api/get-districts/{province_id}', [AddressController::class, 'getDistricts']);
Route::get('api/get-wards/{district_id}',  [AddressController::class, 'getWards']);

//customer - khách hàng
Route::get('/thong-tin-ca-nhan', [CustomerController::class, 'info_customer']);
Route::get('/setting', [CustomerController::class, 'setting_info_customer']);
Route::post('/change-email-customer', [CustomerController::class, 'change_email_customer']);
Route::post('/change-password-customer', [CustomerController::class, 'change_password_customer']);
Route::post('/send-contact-customer', [ContactController::class, 'send_contact_customer']);
Route::post('/upload-avatar-customer/{customer_id}', [CustomerController::class, 'upload_avatar_customer']);
Route::post('/update-info-customer/{customer_id}', [CustomerController::class, 'update_info_customer']);

//history order - lịch sử đơn hàng
Route::get('/history-order', [OrderController::class, 'history_order']);
Route::get('/view-history-order/{order_code}', [OrderController::class, 'view_history_order']);
Route::post('/huy-don-hang', [OrderController::class, 'huy_don_hang']);



//Print_order - in đơn hàng
Route::get('/print-order/{order_code}', [PrintPDFController::class, 'printOrder']);
