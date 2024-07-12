@extends('layout')
@section('content')

<!--features_items-->
<!-- <div class="features_items"> -->
@foreach($brand_name as $key =>$name_br)
<h2 class="title text-center">{{$name_br->brand_name}}</h2>
@endforeach
@foreach($brand_by_id as $key =>$product)
<div class="col-sm-4">
    <div class="card p-3 mb-5" style="width: 18em;">
        <div class="single-products">
            <div class="productinfo text-center">
                <form>
                    @csrf
                    <input type="hidden" class="cart_product_id_{{$product->product_id}}" value="{{$product->product_id}}">
                    <input type="hidden" class="cart_product_name_{{$product->product_id}}" value="{{$product->product_name}}">
                    <input type="hidden" class="cart_product_image_{{$product->product_id}}" value="{{$product->product_image}}">
                    <input type="hidden" class="cart_product_price_{{$product->product_id}}" value="{{$product->product_price}}">
                    <input type="hidden" class="cart_product_qty_{{$product->product_id}}" value="1">
                    <input type="hidden" class="cart_category_product_{{$product->product_id}}" value="{{$product->category_name}}">
                    <input type="hidden" class="cart_brand_product_{{$product->product_id}}" value="{{$product->brand_name}}">

                    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}"> <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" /></a>
                    <p>{{$product->product_name}}</p>
                    <h2>{{number_format($product->product_price)}}<span>₫</span></h2>
                    <?php
                    if ($product->product_condition == "0") {
                    ?>
                       <div class="sold-out-frame">
                            <img class="sold-out" src="{{URL::to('public/frontend/images/product-details/sold_out.png')}}" alt="" style="height: 100px;  width: auto;">
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="btn-show">
                            <button type="button" class="btn btn-outline-danger add-to-cart" name="add-to-cart" data-id="{{$product->product_id}}"><i class="fa fa-shopping-cart"></i>Đặt hàng
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection