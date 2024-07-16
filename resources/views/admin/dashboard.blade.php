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
        <p class="title-statistical m-2 mt-4">THỐNG KÊ DOANH THU</p>
        <div class="card m-2">
            <div class="card-body">
                <form autocomplete="off">
                    @csrf
                    <div class="row m-0">
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
                        <div class="col-md-12 mt-4">
                            <div class="row">
                                <div class="chart col-md-9">
                                    <canvas id="barChart" style="height: 350px; max-width: 100%;"></canvas>
                                </div>
                                <div class="chart col-md-3">
                                    <canvas id="donutChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <p class="title-statistical m-2 mt-4">THỐNG KÊ Lượt xem</p>
        <div class="row m-0">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title">Top 10 các sản phẩm được quan tâm nhiều</label>
                    </div>
                    <div class="card-body">
                        <canvas id="horizontalBarChart1" style="height: 350px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title">Top 10 các bài viết có lượt xem nhiều</label>
                    </div>
                    <div class="card-body">
                        <canvas id="horizontalBarChart2"
                            style="min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
