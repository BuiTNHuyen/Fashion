@extends('frontend.layout.master')
@section('content')
@section('page-class', 'blog')
@section('page-id', 'blog-list-sidebar-left')
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
                                            <a href="#">
                                                <span>Trang chủ</span>
                                            </a>
                                        </li>
                                        <li>
                                            <span>
                                                <span>Tin tức và sự kiện</span>
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
                                        <h2>Bài viết mới</h2>
                                        @foreach ($posts as $post)
                                            <div class="list-content row">
                                                <div class="hover-after col-md-5 col-xs-12">
                                                    <a href="{{route('blog.detail', $post)}}">
                                                        <img src="{{$post->thumbnail}}" alt="img">
                                                    </a>
                                                </div>
                                                <div class="late-item col-md-7 col-xs-12">
                                                    <p class="content-title">
                                                        <a href="{{route('blog.detail', $post)}}">{{$post->title}}</a>
                                                    </p>
                                                    <p class="post-info">
                                                        <span>{{$post->view}} lượt xem</span>
                                                        <span>{{$post->postType->name}}</span>
                                                        <span>{{$post->admin->name}}</span>
                                                    </p>
                                                    <p class="description">
                                                        {!! $post->shortContent($post->content, 200) !!}
                                                    </p>
                                                    <span class="view-more">
                                                        <a href="{{route('blog.detail', $post)}}">Xem thêm</a>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="page-list col">
                                            {{$posts->links()}}
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
