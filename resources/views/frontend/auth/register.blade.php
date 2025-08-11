@extends('frontend.layout.master')
@section('content')
@section('page-id', 'contact')
@section('page-class', 'user-register blog')
    <!-- main content -->
    <div class="main-content">
        <div class="wrap-banner">

            <!-- breadcrumb -->
            <nav class="breadcrumb-bg">
                <div class="container no-index">
                    <div class="breadcrumb">
                        <ol>
                            <li>
                                <a href="">
                                    <span>Trang chủ</span>
                                </a>
                            </li>
                            <li>
                                <span>
                                    <span>Đăng ký</span>
                                </span>
                            </li>
                        </ol>
                    </div>
                </div>
            </nav>
        </div>

        <!-- main -->
        <div id="wrapper-site">
            <div class="container">
                <div class="row">
                    <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 onecol">
                        <div id="main">
                            <div id="content" class="page-content">
                                <div class="register-form text-center">
                                    <h1 class="text-center title-page">Tạo tài khoản</h1>
                                    <form action="{{route('registerPost')}}" id="customer-form" class="js-customer-form" method="post">
                                        @csrf
                                        <div>
                                            <div class="form-group">
                                                <div>
                                                    <input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="Họ tên">
                                                </div>
                                                @error('name')
                                                    <p class="text-left text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <input class="form-control" name="email" type="email" value="{{old('email')}}" placeholder="Email">
                                                </div>
                                                @error('email')
                                                    <p class="text-left text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <div class="input-group js-parent-focus">
                                                        <input class="form-control js-child-focus js-visible-password" name="password" type="password" placeholder="Mật khẩu">
                                                    </div>
                                                </div>
                                                @error('password')
                                                    <p class="text-left text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <div class="input-group js-parent-focus">
                                                        <input class="form-control js-child-focus js-visible-password" name="password_confirmation" type="password" placeholder="Nhập lại mật khẩu">
                                                    </div>
                                                </div>
                                                @error('password_confirmation')
                                                    <p class="text-left text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                            <div class="no-gutters text-center">
                                                <div class="forgot-password">
                                                    <a href="{{route('login')}}" rel="nofollow">
                                                        Đăng nhập tài khoản!
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <div>
                                                <button class="btn btn-primary" data-link-action="sign-in" type="submit">
                                                    Đăng ký
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection /*php*/
