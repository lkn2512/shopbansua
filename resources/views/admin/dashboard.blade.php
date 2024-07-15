@extends('admin_layout')
@section('admin_content')
    <div class="dasboard">
        <div class="market-updates row">
            <div class="col-md-3 market-update-gd">
                <a href="{{ URL::to('Admin/all-product') }}">
                    <div class="market-update-block clr-block-2">
                        <div class="col-md-3 market-update-right">
                            <i class="fa-brands fa-product-hunt"></i>
                        </div>
                        <div class="col-md-9 market-update-left">
                            <h4>Sản phẩm</h4>
                            <h3>{{ number_format($product_count) }}</h3>
                            <p>Tổng sản phẩm hiện có</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 market-update-gd">
                <a href="{{ URL::to('Admin/all-customer') }}">
                    <div class="market-update-block clr-block-1">
                        <div class="col-md-3 market-update-right">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="col-md-9 market-update-left">
                            <h4>Khách hàng</h4>
                            <h3>{{ number_format($customer_count) }}</h3>
                            <p>Tổng khách hàng đăng ký</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 market-update-gd">
                <a href="{{ URL::to('Admin/list-post') }}">
                    <div class="market-update-block clr-block-3">
                        <div class="col-md-3 market-update-right">
                            <i class="fa-solid fa-blog"></i>
                        </div>
                        <div class="col-md-9 market-update-left">
                            <h4>Tin tức</h4>
                            <h3>{{ number_format($post_count) }}</h3>
                            <p>Tổng số tin tức đã đăng</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 market-update-gd">
                <a href="{{ URL::to('Admin/manage-order') }}">
                    <div class="market-update-block clr-block-4">
                        <div class="col-md-3 market-update-right">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-9 market-update-left">
                            <h4>Đơn hàng</h4>
                            <h3>{{ number_format($order_count) }}</h3>
                            <p>Tổng đơn hàng đã đặt</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <form autocomplete="off">
            @csrf
            <div class="row m-0">
                <p class="title-statistical">THỐNG KÊ ĐƠN HÀNG</p>
                <div class="col-md-2">
                    <label class="title-filter">Từ ngày</label>
                    <input type="text" id="datepicker_fromDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="title-filter">Đến ngày</label>
                    <input type="text" id="datepicker_toDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" id="btn-dashboard-filter" class="btn-filter">Lọc kết quả</button>
                </div>
                <div class="col-md-2 offset-md-4">
                    <label class="title-filter">Lọc theo</label>
                    <select class="dashboard-filter form-select">
                        <option value="">--Chọn--</option>
                        <option value="7ngay"> 7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="365ngayqua">365 ngày qua</option>
                    </select>
                </div>
                <div class="col-md-12 chart-content">
                    <div class="chart">
                        <canvas id="barChart"
                            style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </form>
        <br><br>
        <div class="row m-0">
            <div class="col-md-6">
                <label class="title-statistical">Top 10 các bài viết có lượt xem nhiều</label>
                <ul class="views-list">
                    @foreach ($post_views as $pv)
                        <li class="views-li">
                            <a class="title-view underline" target="_blank"
                                href="{{ url('bai-viet/' . $pv->post_id) }}">{{ $pv->post_title }}
                            </a>
                            <span class="number-views">({{ number_format($pv->post_view) }} lượt xem)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <label class="title-statistical">Top 10 Các sản phẩm được quan tâm nhiều</label>
                <ul class="views-list">
                    @foreach ($product_views as $pr)
                        <li class="views-li">
                            <a class="title-view underline" target="_blank"
                                href="{{ url('/chi-tiet-san-pham/' . $pr->product_id) }}">{{ $pr->product_name }}
                            </a>
                            <span class="number-views">({{ number_format($pr->product_view) }} lượt xem)</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div> --}}
@endsection
