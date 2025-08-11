@extends('frontend.layout.master')
@section('content')
@section('page-class', 'blog')
@section('page-id', 'page-404')
    <!-- main content -->
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <section class="page-home">
                    <div class="container">
                        <div class="row center">
                            <div class="content-404 col-lg-6 col-sm-6 text-center">
                                <div class="image">
                                    <img class="img-fluid" src="/assets/frontend/img/other/image-404.png" alt="Image 404">
                                </div>
                                <h2 class="h4">Chúng tôi rất tiếc - đã xảy ra lỗi từ phía chúng tôi.</h2>
                                <div class="info">
                                    <p>Nếu vẫn gặp khó khăn, vui lòng liên hệ với quản trị viên hệ thống của cửa hàng và báo cáo lỗi bên dưới.</p>
                                </div>
                                <a class="btn btn-default" href="/">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>Trở lại trang chủ</span>
                                </a>
                            </div>
                            <div class="content-right-404 col-lg-6 col-sm-6 text-center">
                                <a href="#">
                                    <img class="img-fluid" src="/assets/frontend/img/other/background.jpg" alt="image 404 right">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

    /*php*/
