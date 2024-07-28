<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Gallery;
use App\Models\Section;
use App\Models\Slider;
use App\Models\Video;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Log;

class ManageProductController extends Controller
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
    public function add_product_page()
    {
        $this->AuthLogin();
        $cate_product = CategoryProduct::orderBy('category_name', 'asc')->get();
        $brand_product = Brand::orderBy('brand_name', 'asc')->get();

        $section_product = Section::orderBy('section_name', 'asc')->get();

        $videos = Video::leftJoin('tbl_product', 'tbl_video.video_id', '=', 'tbl_product.video_id')
            ->whereNull('tbl_product.video_id')
            ->orderBy('tbl_video.video_id', 'desc')
            ->select('tbl_video.*')
            ->get();

        return view('admin.product.add_product')->with(compact('cate_product', 'brand_product', 'videos', 'section_product'));
    }

    public function all_product()
    {
        $this->AuthLogin();
        $all_product = Product::orderBy('product_id', 'desc')
            ->with('category')->with('brand')->get();
        $product = Product::get();
        $count_product = $product->count();
        return view('admin.product.all_product')->with(compact('all_product', 'count_product'));
    }
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        try {
            $data = array();
            $number_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
            $number_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
            $number_quantity = filter_var($request->product_quantity, FILTER_SANITIZE_NUMBER_INT);
            $number_promotional_price = filter_var($request->promotional_price, FILTER_SANITIZE_NUMBER_INT);

            $data['product_code'] = $request->product_code;
            $data['product_name'] = $request->product_name;
            $data['product_slug'] = $request->product_slug;
            $data['product_cost'] = $number_cost;
            $data['product_price'] = $number_price;
            if ($number_promotional_price) {
                $data['promotional_price'] = $number_promotional_price;
            } else {
                $data['promotional_price'] = 0;
            }
            $data['product_quantity'] = $number_quantity;
            $data['product_content'] = $request->product_content;
            $data['product_sold'] = 0;
            $data['category_id'] = $request->product_cate;
            $data['brand_id'] = $request->product_brand;
            $data['section_id'] = $request->section_id;
            $data['product_condition'] = $request->product_condition;
            $data['product_status'] = $request->product_status;

            $get_image = $request->file('product_image');

            // Xử lý khi chọn video và lưu vào CSDL
            if ($request->selected_video) {
                $data['video_id'] = $request->selected_video;
            }

            if ($get_image) {
                $mime_type = $get_image->getClientMimeType();
                if (strpos($mime_type, 'image') !== false) {
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                    $get_image->move(public_path('uploads/product/'), $new_image);
                    $data['product_image']  = $new_image;
                } else {
                    Session::put('message', 'Hình ảnh không hợp lệ!');
                    return Redirect::to('Admin/add-product');
                }
            }
            Product::insert($data);
            return response()->json([
                'success' => 'Thêm sản phẩm thành công.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error'
            ]);
        }
    }
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 0]);
        return response()->json(['status' => 'success', 'message' => 'Ẩn.']);
    }

    public function active_product($product_id)
    {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 1]);
        return response()->json(['status' => 'success', 'message' => 'Hiển thị.']);
    }

    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = CategoryProduct::orderBy('category_name', 'asc')->get();
        $brand_product = Brand::orderBy('brand_name', 'asc')->get();
        $section_product = Section::orderBy('section_name', 'asc')->get();

        $edit_product = Product::where('product_id', $product_id)->get();

        // Lấy sản phẩm hiện tại để lấy video_id của nó
        $get_product_id = Product::findOrFail($product_id);
        $current_video_id = $get_product_id->video_id;

        // Lấy các video không liên kết với bất kỳ sản phẩm nào hoặc chỉ liên kết với sản phẩm hiện tại
        $videos = Video::leftJoin('tbl_product', 'tbl_video.video_id', '=', 'tbl_product.video_id')
            ->whereNull('tbl_product.video_id')
            ->orWhere('tbl_video.video_id', $current_video_id)
            ->orderBy('tbl_video.video_id', 'desc')
            ->select('tbl_video.*')
            ->get();

        if ($current_video_id) {
            $video = Video::findOrFail($current_video_id);
            $videoTitle = $video->video_title;
        } else {
            $videoTitle = 'Chưa có video';
        }
        return view('admin.product.edit_product', compact('edit_product', 'cate_product', 'brand_product', 'section_product', 'videos', 'videoTitle'));
    }
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        try {
            $data = array();
            $number_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
            $number_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
            $number_quantity = filter_var($request->product_quantity, FILTER_SANITIZE_NUMBER_INT);
            $number_promotional_price = filter_var($request->promotional_price, FILTER_SANITIZE_NUMBER_INT);

            $data['product_code'] = $request->product_code;
            $data['product_name'] = $request->product_name;
            $data['product_slug'] = $request->product_slug;
            $data['product_cost'] = $number_cost;
            $data['product_price'] = $number_price;
            $data['product_quantity'] = $number_quantity;
            if ($number_promotional_price) {
                $data['promotional_price'] = $number_promotional_price;
            } else {
                $data['promotional_price'] = 0;
            }
            // Xử lý khi chọn video và lưu vào CSDL
            if ($request->selected_video) {
                $data['video_id'] = $request->selected_video;
            }
            $data['product_content'] = $request->product_content;
            $data['category_id'] = $request->product_cate;
            $data['brand_id'] = $request->product_brand;
            $data['section_id'] = $request->section_id;
            $data['product_status'] = $request->product_status;
            $data['product_condition'] = $request->product_condition;

            $new_image_path = null;
            $get_image = $request->file('product_image');
            if ($get_image) {
                $mime_type = $get_image->getClientMimeType();
                if (strpos($mime_type, 'image') !== false) {
                    $product = Product::find($product_id);
                    $product_image = $product->product_image;
                    if ($product_image && file_exists(public_path('uploads/product/' . $product_image))) {
                        unlink(public_path('uploads/product/' . $product_image));
                    }
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                    $get_image->move(public_path('uploads/product/'), $new_image);
                    $data['product_image']  = $new_image;

                    $new_image_path = asset('uploads/product/' . $new_image);
                } else {
                    // return Redirect()->back()->with('error_alert', 'Lỗi định dạng file!');
                }
            }
            Product::where('product_id', $product_id)->update($data);
            // Toastr::success('Đã cập nhật các thay đổi!', '');
            return response()->json([
                'success' => 'Đã cập nhật các thay đổi.',
                'id' => $product_id,
                'new_image_path' => $new_image_path
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_alert', 'Lỗi bất định, vui lòng tải lại trang.');
        }
    }
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        try {
            $product = Product::find($product_id);
            if (!$product) {
                return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.']);
            }
            $product_img = $product->product_image;
            if ($product_img && file_exists(public_path('uploads/product/' . $product_img))) {
                unlink(public_path('uploads/product/' . $product_img));
            }
            $sliders = Slider::where('product_id', $product_id)->get();
            foreach ($sliders as $slider) {
                $slider->product_id = null;
                $slider->save();
            }
            $product->delete();
            return response()->json(['status' => 'success', 'message' => 'Một sản phẩm đã bị xoá.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra khi xoá sản phẩm.', 'error' => $e->getMessage()]);
        }
    }

    //Gallery-product
    public function add_gallery($product_id)
    {
        $this->AuthLogin();
        $pro_id = $product_id;
        $product = Product::where('product_id', $pro_id)->get();
        foreach ($product as $po) {
            $name_product = $po->product_name;
            $code_product = $po->product_code;
            $product_image = $po->product_image;
            $product_id = $po->product_id;
            $product_name = $po->product_name;
        }
        return view('admin.product.add_gallery')->with(compact('pro_id', 'code_product', 'product', 'product_image', 'product_id', 'product_name'));
    }
    public function select_gallery(Request $request)
    {
        $this->AuthLogin();
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id', $product_id)->get();
        $gallery_count = $gallery->count();

        $output = '<form>
            ' . csrf_field() . '
                <div class="row">';

        if ($gallery_count > 0) {
            $i = 0;
            foreach ($gallery as  $gal) {
                $i++;
                $output .= '
                <div class="col-md-3 mb-4 text-center">
                    <div class="position-relative card-gallery-img">
                        <img class="img-gallery" src="' . url('/uploads/gallery/' . $gal->gallery_image) . '" alt="Gallery Image" >
                        <div class="position-absolute top-0 end-0">
                            <a data-gal_id="' . $gal->gallery_id . '" href="#" class="btn-remove-img delete-gallery m-2"><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="input-changeImage" title="Thay đổi ảnh">
                            <input type="file" class="file_image file-Image-input d-none" data-gal_id="' . $gal->gallery_id . '" id="file-' . $gal->gallery_id . '" name="file" accept="image/*"/>
                            <a href="#" class="img-upload" onclick="document.getElementById(\'file-' . $gal->gallery_id . '\').click(); return false;"><i class="fa-solid fa-image"></i></a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            $output .= '
            <div class="col-12">
                <div class="gallery-nullImg">Trống!</div>
            </div>';
        }

        $output .= '
                </div>
        </form>';
        echo $output;
    }
    public function insert_gallery(Request $request, $pro_id)
    {
        $this->AuthLogin();
        try {
            $get_image = $request->file('file');
            if ($get_image) {
                foreach ($get_image as $image) {
                    $get_name_image = $image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/gallery/'), $new_image);
                    $gallery = new Gallery();
                    $gallery->gallery_name = $new_image;
                    $gallery->gallery_image = $new_image;
                    $gallery->product_id = $pro_id;
                    $gallery->save();
                }
                Toastr::success('Tải hình ảnh thành công.');
                return redirect()->back();
            } else {
                return redirect()->back()->with('error_alert', 'Vui lòng chọn tối thiểu một ảnh!');
            }
        } catch (\Throwable $th) {
            Log::error('Error in insert_gallery: ' . $th->getMessage());
            return redirect()->back()->with('error_alert', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    }


    // public function update_gallery_name(Request $request)
    // {
    //     $this->AuthLogin();
    //     $gal_id = $request->gal_id;
    //     $gal_text = $request->gal_text;
    //     $gallery = Gallery::find($gal_id);
    //     $gallery->gallery_name = $gal_text;
    //     $gallery->save();
    // }
    public function delete_gallery(Request $request)
    {
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        $gallery_img = $gallery->gallery_image;
        if ($gallery_img && file_exists(public_path('uploads/gallery/' . $gallery_img))) {
            unlink(public_path('uploads/gallery/' . $gallery_img));
        }
        $gallery->delete();
    }
    public function update_gallery(Request $request)
    {
        $this->AuthLogin();
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if ($get_image) {
            $gallery = Gallery::find($gal_id);
            $gallery_img = $gallery->gallery_image;
            if ($gallery_img && file_exists(public_path('uploads/gallery/' . $gallery_img))) {
                unlink(public_path('uploads/gallery/' . $gallery_img));
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(public_path('/uploads/gallery/'), $new_image);
            $gallery->gallery_image = $new_image;
            $gallery->save();
        }
    }
    public function update_img_product(Request $request)
    {
        $this->AuthLogin();
        $product_id = $request->input('product_id');
        $get_image = $request->file('file_img');

        if ($get_image) {
            $mime_type = $get_image->getClientMimeType();
            if (strpos($mime_type, 'image') !== false) {
                $product = Product::find($product_id);
                if ($product) {
                    $product_image = $product->product_image;
                    if ($product_image && file_exists(public_path('uploads/product/' . $product_image))) {
                        unlink(public_path('uploads/product/' . $product_image));
                    }
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.', $get_name_image));
                    $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                    $get_image->move(public_path('uploads/product/'), $new_image);
                    $product->product_image = $new_image;
                    $product->save();
                } else {
                    return Redirect()->back()->with('error_alert', 'Sản phẩm không tồn tại!');
                }
            } else {
                Toastr::error('Định dạng tập tin không hợp lệ');
                return Redirect()->back();
            }
        } else {
            return Redirect()->back()->with('error_alert', 'Không có tệp nào được chọn!');
        }
        Toastr::success('Ảnh đại diện sản phẩm đã được thay đổi');
        return Redirect()->back();
    }
}
