<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Comment;
use App\Models\Customer;
use App\Models\FavoritesList;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function details_product(Request $request, $product_id)
    {
        $category = CategoryProduct::where('category_status', '1')->orderBy('category_name', 'asc')->get();
        $brand = Brand::where('brand_status', '1')->orderBy('brand_name', 'asc')->get();

        // chi tiết sản phẩm
        $detail_product = Product::orderBy('product_id', 'desc')
            ->with('category')->with('brand')->with('video')
            ->where('product_id', $product_id)->get();
        if ($detail_product->isEmpty()) {
            abort(404);
        }
        foreach ($detail_product as $val) {
            $category_id = $val->category_id;
            $brand_id = $val->brand_id;
            $product_id = $val->product_id;
            $product_cate = $val->category->category_name;
            $product_name = $val->product_name;
        }
        //Thư viện hình ảnh
        $gallery = Gallery::where('product_id', $product_id)->get();
        // yêu thích
        $favorite = FavoritesList::where('customer_id', Session::get('customer_id'))->where('product_id', $product_id)->first();
        // sản phẩm liên quan
        $related = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)
            ->where('product_condition', '1')
            ->where('product_status', '1')
            ->whereNotIn('tbl_product.product_id', [$product_id])->get();
        // sản phẩm cùng thương hiệu
        $same_brand = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_brand.brand_id', $brand_id) // Lấy sản phẩm cùng thương hiệu
            // ->where('tbl_category_product.category_id', '!=', $category_id) // Không thuộc cùng loại
            ->where('product_condition', '1')
            ->where('product_status', '1')
            ->whereNotIn('tbl_product.product_id', [$product_id])
            ->limit(12)
            ->get();
        $customer = Customer::where('customer_id', Session::get('customer_id'))->get();
        //update-views
        $product = Product::where('product_id', $product_id)->first();
        $product->product_view = $product->product_view + 1;
        $product->save();
        //Sản phẩm khuyến mãi
        $promotional_product = Product::where('product_status', '1')->where('promotional_price', '>', '0')->whereNotIn('product_id', [$product_id])->inRandomOrder()->limit(5)->get();
        // Tính toán giá trị trung bình
        $product = Product::find($product_id);
        $averageRating = $product->averageRating();
        // Tính toán phần trăm đánh giá theo từng sao
        $totalRatings = $product->ratings()->count();
        $starPercentages = [];
        for ($star = 5; $star >= 1; $star--) {
            $count = $product->ratings()->where('rating', $star)->count();
            $starPercentages[$star] = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0;
        }
        return view('pages.productDetail.show_detail')
            ->with(compact('category', 'brand', 'detail_product', 'related', 'same_brand', 'gallery', 'product_cate', 'category_id', 'product_name', 'product_id', 'product_id', 'customer', 'favorite', 'promotional_product', 'product', 'averageRating', 'starPercentages'));
    }

    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comments = Comment::where('comment_product_id', $product_id)
            ->where('comment_parent_comment', '0')
            ->orderBy('comment_id', 'DESC')
            ->with('customer.ratings')
            ->paginate(6);

        $comment_reply = Comment::where('comment_product_id', $product_id)
            ->where('comment_parent_comment', '>', '0')
            ->orderBy('comment_id', 'asc')
            ->get();

        $output = '<div class="comment-container">';
        foreach ($comments as $comm) {
            // Kiểm tra xem khách hàng có tồn tại không và lấy image
            $customer = $comm->customer;
            $getImage = $customer ? $customer->customer_image : null;
            // Nhận đánh giá cho sản phẩm hiện tại của khách hàng
            $rating = $customer ? $customer->ratings->where('product_id', $product_id)->first() : null;
            // Đặt xếp hạng nếu nó tồn tại
            $comm->rating = $rating ? $rating->rating : null;
            $output .= '    <div class="row comment-show">';
            $output .= '        <div class="col-lg-1 col-md-1 col-sm-2">';
            $output .= '            <div class="comment-image text-center">';
            if ($getImage) {
                $output .= '            <img src="' . asset('uploads/customer/' . $getImage) . '">';
            } else {
                $output .= '            <img src="' . asset('frontend/images/home/avatar-default.jpg') . '">';
            }
            $output .= '            </div>';
            $output .= '        </div>';
            $output .= '        <div class="col-lg-11 col-md-11 col-sm-10 comment-customer p-0">';
            $output .= '            <div class="comment-content">';
            $output .= '                <span class="name">' . htmlspecialchars($comm->comment_name) . '</span>';
            $output .= '                <span class="date"><i class="fa-regular fa-clock"></i> ' . date('H:i, d-m-Y', strtotime($comm->comment_date)) . '</span>';

            // Hiển thị số sao đã đánh giá
            if ($comm->rating !== null) {
                $output .= '                <div class="rating-stars">';
                for ($i = 1; $i <= 5; $i++) {
                    $output .= '                <span class="star' . ($i <= $comm->rating ? ' filled' : '') . '">&#9733;</span>';
                }
                $output .= '                </div>';
            }
            $output .= '                <p class="text">' . htmlspecialchars($comm->comment) . '</p>';
            if ($comm->customer_id == Session::get('customer_id')) {
                $output .= '                <input class="comment-id" type="hidden" value="' . htmlspecialchars($comm->comment_id) . '">';
                $output .= '                <a type="button" class="recall-comment" data-comment_id="' . htmlspecialchars($comm->comment_id) . '">Xoá bình luận</a>';
            }
            $output .= '            </div>';
            $output .= '        </div>';
            $output .= '    </div>';
            foreach ($comment_reply as $comm_rep) {
                if ($comm_rep->comment_parent_comment == $comm->comment_id) {
                    $output .= '    <div class="row comment-reply-admin">';
                    $output .= '        <div class="col-lg-1 col-md-2 col-sm-2">';
                    $output .= '            <div class="image-comment text-center">';
                    $output .= '                <img src="' . url('/uploads/user/162367734844593.jpg') . '">';
                    $output .= '            </div>';
                    $output .= '        </div>';
                    $output .= '        <div class="col-lg-11 col-md-10 col-sm-10">';
                    $output .= '            <div class="comment-content-reply">';
                    $output .= '                <span class="name">' . htmlspecialchars($comm_rep->comment_name) . '</span>';
                    $output .= '                <span class="date"><i class="fa-regular fa-clock"></i> ' . date('H:i, d/m/Y', strtotime($comm_rep->comment_date)) . '</span>';
                    $output .= '                <p class="text">' . htmlspecialchars($comm_rep->comment) . '</p>';
                    $output .= '            </div>';
                    $output .= '        </div>';
                    $output .= '    </div>';
                }
            }
            $output .= '<hr>';
        }
        $output .= '</div>';
        $pagination = $comments->links('pagination::bootstrap-4');
        $output .= '<footer class="panel-footer">' . $pagination . '</footer>';

        return response()->json([
            'output' => $output
        ]);
    }

    public function send_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $customer_id = $request->customer_id;
        $rating = $request->rating;

        // // Kiểm tra xem khách hàng đã đăng bình luận trước đó chưa
        $existingComment = Comment::where('comment_product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->first();

        if ($existingComment) {
            // ví dụ như thông báo lỗi hoặc cho phép cập nhật bình luận.
            return response()->json(['error' => 'Bạn chỉ được phép đăng bình luận một lần cho mỗi sản phẩm']);
        }

        // Lưu bình luận vào bảng Comment
        $comment = new Comment();
        $comment->comment_name = $comment_name;
        $comment->comment = $comment_content;
        $comment->comment_product_id = $product_id;
        $comment->comment_parent_comment = 0;
        $comment->customer_id = $customer_id;
        $comment->save();

        // Lưu số sao vào bảng Rating
        $ratingData = new Rating();
        $ratingData->product_id = $product_id;
        $ratingData->customer_id = $customer_id;
        $ratingData->rating = $rating;
        $ratingData->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ratingData->save();

        return response()->json(['success' => true]);
    }


    public function recall_comment(Request $request)
    {
        // Tìm bình luận chính
        $comment = Comment::where('comment_id', $request->comment_id)->first();
        if ($comment) {
            // Tìm tất cả các phản hồi của bình luận
            $comment_replies = Comment::where('comment_parent_comment', $request->comment_id)->get();
            // Xóa tất cả các phản hồi
            foreach ($comment_replies as $com_rep) {
                $com_rep->delete();
            }
            // Xóa tất cả các đánh giá (ratings) liên quan đến bình luận của khách hàng (customer_id)
            Rating::where('customer_id', $comment->customer_id)
                ->where('product_id', $comment->comment_product_id)
                ->delete();
            // Xóa bình luận chính
            $comment->delete();
        }
    }
}
