@extends('frontend.layout.master')
@section('content')
@section('page-id', 'contact')
@section('page-class', 'user-login blog')

    <!-- main content -->
    <div class="main-content">
        <div class="wrap-banner">

            <!-- breadcrumb -->
            <nav class="breadcrumb-bg">
                <div class="container no-index">
                    <div class="breadcrumb">
                        <ol>
                            <li>
                                <a href="/">
                                    <span>Trang chủ</span>
                                </a>
                            </li>
                            <li>
                                <span>
                                    <span>Đăng nhập</span>
                                </span>
                            </li>
                        </ol>
                    </div>
                </div>
            </nav>

        </div>

        <!-- main -->
        <div id="wrapper-site">
            <div id="content-wrapper" class="full-width">
                <div id="main">
                    <div class="container">
                        <h1 class="text-center title-page">Đăng nhập</h1>
                        @error('status')
                            <p class="text-center text-danger">{{$message}}</p>
                        @enderror
                        <div class="login-form">
                            <form id="customer-form" action="{{route('loginPost')}}" method="post">
                                @csrf
                                <div>
                                    <input type="hidden" name="back" value="my-account">
                                    <div class="form-group no-gutters">
                                        <input class="form-control" name="email" type="email" placeholder=" Email" value="{{old('email')}}">
                                        @error('email')
                                            <p class="text-left text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group no-gutters">
                                        <div class="input-group js-parent-focus">
                                            <input class="form-control js-child-focus js-visible-password" name="password" type="password" value="" placeholder="Mật khẩu">
                                        </div>
                                    </div>
                                    <div class="no-gutters text-center d-flex justify-content-between">

                                        <!-- Đã xóa link quên mật khẩu ở đây -->

                                        <div class="forgot-password">
                                            <a href="{{route('register')}}" rel="nofollow">
                                                Tạo tài khoản mới!
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="text-center no-gutters">
                                        <input type="hidden" name="submitLogin" value="1">
                                        <button class="btn btn-primary" data-link-action="sign-in" type="submit">
                                            Đăng nhập
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

@endsection