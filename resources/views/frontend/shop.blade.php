@extends('frontend.layout.master')
@section('content')
@section('page-id', 'product-sidebar-left')
@section('page-class', 'product-grid-sidebar-left')
    <!-- main content -->
    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper" class="full-width">
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
                                                <span>CỬa hàng</span>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </nav>

                        <div class="container">
                            <div class="content">
                                <form action="">
                                    <div class="row">
                                        <div class="sidebar-3 sidebar-collection col-lg-3 col-md-4 col-sm-4">
                                            <!-- category menu -->
                                            @include('frontend.layout.categories-sidebar')
                                            <!-- best seller -->
                                            <div class="sidebar-block">
                                                <div class="title-block">Catalog</div>
                                                <div class="new-item-content">
                                                    <h3 class="title-product">Thương hiệu</h3>
                                                    <ul class="scroll-product">
                                                        @foreach ($brands as $key=>$brand)
                                                            <li>
                                                                <label class="check" for="brand-{{$key}}">
                                                                    <input type="checkbox" name="thuong_hieu[{{$brand->id}}]" id="brand-{{$key}}"
                                                                    {{ (request('thuong_hieu')[$brand->id] ?? '' ) == 'on' ? 'checked' : ''}} onchange="this.form.submit()">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span>
                                                                    <b>{{ $brand->name}}</b>
                                                                    <span class="quantity">({{$brand->products->count()}})</span>
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="new-item-content">
                                                    <h3 class="title-product">Nơi sản xuất</h3>
                                                    <ul class="scroll-product">
                                                        @foreach ($origins as $key=>$origin)
                                                            <li>
                                                                <label class="check" for="origin-{{$key}}">
                                                                    <input type="checkbox" name="xuat_xu[{{$origin->id}}]" id="origin-{{$key}}"
                                                                    {{ (request('xuat_xu')[$origin->id] ?? '' ) == 'on' ? 'checked' : ''}} onchange="this.form.submit()">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <span>
                                                                    <b>{{$origin->name}}</b>
                                                                    <span class="quantity">({{$origin->products->count()}})</span>
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-lg-9 col-md-8 product-container">
                                            @if (request('keyword'))
                                                <h4>Kết quả tìm kiếm cho: <b>{{request('keyword')}}</b></h4>
                                            @else
                                                <h1>Sản phẩm</h1>
                                            @endif
                                            <div class="js-product-list-top firt nav-top">
                                                <div class="d-flex justify-content-around row">
                                                    <div class="col col-xs-12">
                                                        <ul class="nav nav-tabs">
                                                            <li>
                                                                <a href="#grid" data-toggle="tab" class="active show fa fa-th-large"></a>
                                                            </li>
                                                        </ul>
                                                        <div class="hidden-sm-down total-products">
                                                            <p>Có {{$products->total()}} sản phẩm</p>
                                                        </div>
                                                    </div>
                                                    <div class="col col-xs-12">
                                                        <div class="d-flex sort-by-row justify-content-lg-end justify-content-md-end">
                                                            <div class="products-sort-order dropdown">
                                                                <select class="select-title" name="sort_by" onchange="this.form.submit()">
                                                                    <option value="" disabled selected>Sắp xếp</option>
                                                                    <option {{ request('sort_by') == 'discount' ? 'selected' : ''}} value="discount">Giảm giá</option>
                                                                    <option {{ request('sort_by') == 'latest' ? 'selected' : ''}} value="latest">Mới nhất</option>
                                                                    <option {{ request('sort_by') == 'oldest' ? 'selected' : ''}} value="oldest">Cũ nhât</option>
                                                                    <option {{ request('sort_by') == 'price-ascending' ? 'selected' : ''}} value="price-ascending">Giá tăng dần</option>
                                                                    <option {{ request('sort_by') == 'price-desending' ? 'selected' : ''}} value="price-desending">Giá giảm dần</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-content product-items">
                                                <div id="grid" class="related tab-pane fade in active show">
                                                    <div class="row">
                                                        @foreach ($products as $product)
                                                            <div class="item text-center col-md-4">
                                                                @include('frontend.layout.product-info')
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
    
                                            <!-- pagination -->
                                            <div class="pagination justify-content-center">
                                                {{$products->withQueryString()->links()}}
                                            </div>
                                        </div>
    
                                        <!-- end col-md-9-1 -->
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 /*php*/
