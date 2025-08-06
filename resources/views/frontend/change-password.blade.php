@extends('frontend.layout.master')
@section('content')
@section('page-class', 'user-acount')
@push('css')
    <style>
        
    </style>
@endpush
<div class="main-content">
    <div class="wrap-banner">
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
                                <span>Đổi mật khẩu</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </nav>

        <div class="acount head-acount">
            <div class="container">
                <div id="main">
                    <h1 class="title-page">Đổi mật khẩu</h1>
                    <div class="content" id="block-history">
                        <form action="{{route('account.update-password')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="old_password">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" >
                                @error('old_password')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @error('password')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection