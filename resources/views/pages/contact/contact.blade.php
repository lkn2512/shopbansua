@extends('layout')
@section('content')
    <section class="ftco-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters mb-5">
                        <div class="col-md-7">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4 title">Liên hệ với chúng tôi</h3>
                                <form method="POST" id="contactForm" class="contactForm"
                                    action="{{ URL::to('/send-contact-customer') }}">
                                    @csrf
                                    <div class="row">
                                        @foreach ($customer as $cus)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-title" for="name">Họ và tên</label>
                                                    <input type="text" class="form-control size" name="name"
                                                        id="name" placeholder="Họ và tên" maxlength="50"
                                                        value="{{ $cus->customer_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="label-title" for="email">Địa chỉ email</label>
                                                    <input type="email" class="form-control size" name="email"
                                                        id="email" placeholder="Email" maxlength="50"
                                                        value="{{ $cus->customer_email }}" required>
                                                    @if ($errors->has('email'))
                                                        <span class="error-message">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-title" for="subject">Chủ thể</label>
                                                <input type="text" class="form-control size" name="subject"
                                                    id="subject" placeholder="Chủ thể" value="{{ old('subject') }}"
                                                    maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="label-title" for="#">Nội dung</label>
                                                <textarea name="message" class="form-control" id="message" cols="30" rows="4" placeholder="Nội dung"
                                                    required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="Gửi liên hệ" class="btn-send-contact">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-stretch">
                            <div id="map">
                                @foreach ($contact as $key => $value_contact)
                                    {!! $value_contact->info_map !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($contact as $key => $value_contact)
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-map-marker"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>Địa chỉ:</span> <a href="#">{{ $value_contact->info_address }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-phone"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>Số điện thoại:</span> <a href="#">
                                                {{ $value_contact->info_phone }}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-paper-plane"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>Email:</span> <a href="#">{{ $value_contact->info_email }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dbox w-100 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-globe"></span>
                                    </div>
                                    <div class="text">
                                        <p><span>Website: </span> <a href="#">knmilk.com</a></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
