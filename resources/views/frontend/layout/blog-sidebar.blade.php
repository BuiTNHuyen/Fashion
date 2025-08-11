<div class="sidebar-3 sidebar-collection col-lg-3 col-md-3 col-sm-4">
    <!-- category -->
    <div class="sidebar-block">
        <div class="title-block">Danh mục</div>
        <div class="block-content">
            @foreach($post_types as $type)
            <div class="cateTitle hasSubCategory open level1">
                <a class="cateItem" href="#">{{$type->name}}</a>
            </div>
            @endforeach
        </div>
    </div>


    <!-- recent posts -->
    <div class="sidebar-block">
        <div class="title-block">Bài viết xem nhiều</div>
        <div class="post-item-content">
            @foreach($topPosts as $post)
            <div>
                <div class="late-item first-child">
                    <a href="{{route('blog.detail', $post)}}">
                        <p class="content-title">{{$post->title}}</p>
                    </a>
                    <span>
                        <i class="zmdi zmdi-comments"></i>{{$post->view}} luợt xem</span>
                    <span>
                        <i class="zmdi zmdi-calendar-note"></i>{{date_format($post->created_at, 'd/m/Y')}}
                    </span>
                    <p class="description">
                        {!! $post->shortContent($post->content, 80) !!}
                    </p>
                    <p class="remove">
                        <a href="{{route('blog.detail', $post)}}">Xem thêm</a>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- advertising -->
    <div class="sidebar-block group-image-special">
        <div class="effect">
            <a href="#">
                <img class="img-fluid" src="/assets/frontend/img/blog/advertising.jpg" alt="banner-2" title="banner-2">
            </a>
        </div>
    </div>
</div> /*php*/
