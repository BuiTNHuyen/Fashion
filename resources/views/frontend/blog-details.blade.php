@extends('frontend.layout.master')
@section('content')
@section('page-id', 'blog-detail')
@section('page-class', 'blog')

    <!-- main content -->
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <div id="main">
                    <div class="page-home">

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
                                            <a href="#">
                                                <span>{{$post->postType->name}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                <span>{{$post->title}}</span>
                                            </span>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </nav>
                        <div class="container">
                            <div class="content">
                                <div class="row">
                                    @include('frontend.layout.blog-sidebar')
                                    <div class="col-sm-8 col-lg-9 col-md-9 flex-xs-first main-blogs">
                                        <h3>{{$post->title}}</h3>
                                        <div class="hover-after">
                                            <img src="{{$post->thumbnail}}" alt="img" class="img-fluid">
                                        </div>
                                        <div class="late-item">
                                            {!! $post->content !!}
                                            <div class="border-detail">
                                                <p class="post-info float-left">
                                                    <span>{{$post->view}} lượt xem</span>
                                                    <span>{{$post->postType->name}}</span>
                                                    <span>{{$post->admin->name}}</span>
                                                </p>
                                                <div class="btn-group">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-share"></i>
                                                        <span>Share</span>
                                                    </a>
                                                    <a href="#" class="email">
                                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                                        <span>SEN TO A FRIEND</span>
                                                    </a>
                                                    <a href="#" class="print">
                                                        <i class="zmdi zmdi-print"></i>
                                                        <span>Print</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="related">
                                            <h2 class="title-block">Bài viết liên quan</h2>
                                            <div class="main-blogs">
                                                <div class="row">
                                                    @foreach($relatedPosts as $post)
                                                    <div class="col-md-4">
                                                        <div class="hover-after">
                                                            <a href="{{route('blog.detail', $post)}}">
                                                                <img src="{{$post->thumbnail}}" alt="img" class="img-fluid">
                                                            </a>
                                                        </div>
                                                        <div class="late-item">
                                                            <p class="content-title">
                                                                <a href="{{route('blog.detail', $post)}}">{{$post->title}}</a>
                                                            </p>
                                                            <p class="description">
                                                                {!! $post->shortContent($post->content) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection /*php*/
