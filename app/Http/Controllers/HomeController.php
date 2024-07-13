<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Customer;
use App\Models\HolidayEvent;
use App\Models\Information;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_name', 'asc')->get();
        $all_product_new = Product::where('product_status', '1')->where('product_condition', '1')->orderBy('product_id', 'desc')->limit(12)->get();
        $slider = Slider::orderby('slider_id', 'desc')->where('slider_status', '1')->get();
        $selling_product = Product::where('product_status', '1')->where('product_condition', '1')->where('product_sold', '>', 0)->orderBy('product_sold', 'desc')->limit(12)->get();
        $promotional_product = Product::where('product_status', '1')->where('promotional_price', '>', '0')->orderBy('product_id', 'desc')->limit(12)->get();
        $contact = Information::first();
        $customer_id = Session::get('customer_id');
        if ($customer_id) {
            $customer = Customer::where('customer_id', $customer_id)->get();
        } else {
            $customer = 0;
        }
        $holidayEvent = HolidayEvent::orderBy('event_date', 'desc')->where('event_status', 1)->get();
        $productsByEvent = [];
        foreach ($holidayEvent as $event) {
            // Lấy danh sách sản phẩm thuộc sự kiện hiện tại
            $productsByEvent[$event->holiday_event_id] = $event->products()->get();
        }
        //sản phẩm được quan tâm nhiều nhất
        $view_product = Product::where('product_status', '1')->where('product_condition', '1')->where('product_view', '>', 0)->orderBy('product_view', 'desc')->limit(12)->get();

        //sản phẩm nối bật dựa trên đánh giá sao
        $featuredProducts = Product::with('ratings')->withAvg('ratings', 'rating')->orderByDesc('ratings_avg_rating')->take(12)->get();

        return view('pages.home')->with(compact('category', 'brand', 'all_product_new', 'slider', 'selling_product', 'contact', 'customer', 'promotional_product', 'holidayEvent', 'productsByEvent', 'view_product', 'featuredProducts'));
    }
    public function all_products_new()
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');

        $query = Product::where('product_status', '1')->where('product_condition', '1');

        if (isset($_GET['category'])) {
            $category_ids = explode(',', $_GET['category']);
            $query->whereIn('category_id', $category_ids);
        }
        if (isset($_GET['brand'])) {
            $brand_ids = explode(',', $_GET['brand']);
            $query->whereIn('brand_id', $brand_ids);
        }
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            switch ($sort_by) {
                case 'new':
                    $all_product_new = $query->orderBy('product_id', 'desc')->paginate(20);
                    break;
                case 'old':
                    $all_product_new = $query->orderBy('product_id', 'asc')->paginate(20);
                    break;
                case 'giam_dan':
                    $all_product_new = $query->orderBy('product_price', 'desc')->paginate(20);
                    break;
                case 'tang_dan':
                    $all_product_new = $query->orderBy('product_price', 'asc')->paginate(20);
                    break;
                case 'kytu_az':
                    $all_product_new = $query->orderBy('product_name', 'asc')->paginate(20);
                    break;
                case 'kytu_za':
                    $all_product_new = $query->orderBy('product_name', 'desc')->paginate(20);
                    break;
                default:
                    $all_product_new = $query->orderBy('product_id', 'desc')->paginate(20);
                    break;
            }
        } elseif (isset($_GET['start_price']) && isset($_GET['end_price'])) {
            $min_prices = $_GET['start_price'];
            $max_prices = $_GET['end_price'];
            $all_product_new = $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc')->paginate(20);
        } else {
            $all_product_new = $query->orderBy('product_id', 'desc')->paginate(20);
        }
        return view('pages.product-all.all_product_new')->with(compact('all_product_new', 'min_price', 'max_price', 'category', 'brand'));
    }

    public function all_product_selling()
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $min_price = Product::where('product_sold', '>', 0)->min('product_price');
        $max_price = Product::where('product_sold', '>', 0)->max('product_price');

        $query = Product::where('product_status', '1')->where('product_condition', '1')->where('product_sold', '>', 0);

        if (isset($_GET['category'])) {
            $category_ids = explode(',', $_GET['category']);
            $query->whereIn('category_id', $category_ids);
        }
        if (isset($_GET['brand'])) {
            $brand_ids = explode(',', $_GET['brand']);
            $query->whereIn('brand_id', $brand_ids);
        }
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'new') {
                $product_selling = $query->orderBy('product_id', 'desc')->paginate(20);
            } elseif ($sort_by == 'old') {
                $product_selling = $query->orderBy('product_id', 'asc')->paginate(20);
            } elseif ($sort_by == 'giam_dan') {
                $product_selling = $query->orderBy('product_price', 'desc')->paginate(20);
            } elseif ($sort_by == 'tang_dan') {
                $product_selling = $query->orderBy('product_price', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_az') {
                $product_selling = $query->orderBy('product_name', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_za') {
                $product_selling = $query->orderBy('product_name', 'desc')->paginate(20);
            }
        } elseif (isset($_GET['start_price']) && ($_GET['end_price'])) {
            $min_prices = $_GET['start_price'];
            $max_prices = $_GET['end_price'];
            $product_selling = $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc')->paginate(20);
        } else {
            $product_selling = $query->orderBy('product_sold', 'desc')->paginate(20);
        }
        return view('pages.product-all.all-product-selling')->with(compact('product_selling', 'min_price', 'max_price', 'category', 'brand'));
    }

    public function all_featuredProducts()
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $min_price = Product::where('product_sold', '>', 0)->min('product_price');
        $max_price = Product::where('product_sold', '>', 0)->max('product_price');

        $query = Product::with('ratings')->withAvg('ratings', 'rating');

        if (isset($_GET['category'])) {
            $category_ids = explode(',', $_GET['category']);
            $query->whereIn('category_id', $category_ids);
        }
        if (isset($_GET['brand'])) {
            $brand_ids = explode(',', $_GET['brand']);
            $query->whereIn('brand_id', $brand_ids);
        }
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'new') {
                $featuredProducts = $query->orderBy('product_id', 'desc')->paginate(20);
            } elseif ($sort_by == 'old') {
                $featuredProducts = $query->orderBy('product_id', 'asc')->paginate(20);
            } elseif ($sort_by == 'giam_dan') {
                $featuredProducts = $query->orderBy('product_price', 'desc')->paginate(20);
            } elseif ($sort_by == 'tang_dan') {
                $featuredProducts = $query->orderBy('product_price', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_az') {
                $featuredProducts = $query->orderBy('product_name', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_za') {
                $featuredProducts = $query->orderBy('product_name', 'desc')->paginate(20);
            }
        } elseif (isset($_GET['start_price']) && ($_GET['end_price'])) {
            $min_prices = $_GET['start_price'];
            $max_prices = $_GET['end_price'];
            $featuredProducts = $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc')->paginate(20);
        } else {
            $featuredProducts = $query->orderByDesc('ratings_avg_rating')->paginate(20);
        }
        return view('pages.product-all.all-product-featured')->with(compact('featuredProducts', 'min_price', 'max_price', 'category', 'brand'));
    }
    public function all_product_view()
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $min_price = Product::where('product_sold', '>', 0)->min('product_price');
        $max_price = Product::where('product_sold', '>', 0)->max('product_price');

        $query = Product::where('product_status', '1')->where('product_view', '>', '0');

        if (isset($_GET['category'])) {
            $category_ids = explode(',', $_GET['category']);
            $query->whereIn('category_id', $category_ids);
        }
        if (isset($_GET['brand'])) {
            $brand_ids = explode(',', $_GET['brand']);
            $query->whereIn('brand_id', $brand_ids);
        }
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'new') {
                $product_view = $query->orderBy('product_id', 'desc')->paginate(20);
            } elseif ($sort_by == 'old') {
                $product_view = $query->orderBy('product_id', 'asc')->paginate(20);
            } elseif ($sort_by == 'giam_dan') {
                $product_view = $query->orderBy('product_price', 'desc')->paginate(20);
            } elseif ($sort_by == 'tang_dan') {
                $product_view = $query->orderBy('product_price', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_az') {
                $product_view = $query->orderBy('product_name', 'asc')->paginate(20);
            } elseif ($sort_by == 'kytu_za') {
                $product_view = $query->orderBy('product_name', 'desc')->paginate(20);
            }
        } elseif (isset($_GET['start_price']) && ($_GET['end_price'])) {
            $min_prices = $_GET['start_price'];
            $max_prices = $_GET['end_price'];
            $product_view = $query->whereBetween('product_price', [$min_prices, $max_prices])->orderBy('product_price', 'asc')->paginate(20);
        } else {
            $product_view = $query->orderBy('product_view', 'desc')->paginate(20);
        }
        return view('pages.product-all.all-product-view')->with(compact('product_view', 'min_price', 'max_price', 'category', 'brand'));
    }


    public function search_items(Request $request)
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_id', 'desc')->get();

        $keywords = $request->keywords_submit;

        $search_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('product_status', '1')->where('product_condition', '1')
            ->where('product_name', 'like', '%' . $keywords . '%')
            ->orWhere('category_name', 'like', '%' . $keywords . '%')
            ->orWhere('brand_name', 'like', '%' . $keywords . '%')
            ->paginate(24);
        $count_search_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('product_status', '1')->where('product_condition', '1')
            ->where('product_name', 'like', '%' . $keywords . '%')
            ->orWhere('category_name', 'like', '%' . $keywords . '%')
            ->orWhere('brand_name', 'like', '%' . $keywords . '%')
            ->count();
        return view('pages.productDetail.search')->with(compact('search_product', 'keywords', 'count_search_product', 'category', 'brand'));
    }
    public function autocomplete_ajax(Request $request)
    {
        $data = $request->all();
        if ($data['query']) {
            $product = Product::where('product_status', 1)->where('product_name', 'LIKE', '%' . $data['query'] . '%')->limit(5)->get();
            $output = ' <ul class="dropdown-menu dropdown-hover" style="display:block;  border-radius: 0;">';
            foreach ($product as $key => $value) {
                $output .= '<li><a class="dropdown-item item-hover li-search-ajax"><i class="fa-solid fa-magnifying-glass"></i>&ensp;' . $value->product_name . '</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
