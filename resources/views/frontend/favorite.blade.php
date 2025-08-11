@extends('frontend.layout.master')
@section('content')
@section('page-id', 'contact')
@section('page-class', 'user-wishlist blog')
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
                                    <span>Yêu thích</span>
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
                                <div id="mywishlist">
                                    <h1 class="title-page">Sản phẩm yêu thích</h1>
                                    <div id="block-history" class="block-center">
                                        <table class="std table">
                                            <thead>
                                                <tr>
                                                    <th class="first_item">STT</th>
                                                    <th class="first_item">Tên sản phẩm</th>
                                                    <th class="item mywishlist_first">Tình trạng</th>
                                                    <th class="item mywishlist_second">Xem sản phẩm</th>
                                                    <th class="last_item mywishlist_first">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($favoriteProducts as $key=>$product)
                                                <tr id="wishlist_1">
                                                    <td>{{$key+1}}</td>
                                                    <td>
                                                        <a href="{{route('product', $product)}}">{{$product->name}}</a>
                                                    </td>
                                                    <td class="bold align_center">
                                                        @if ($product->quantity > 0)
                                                            <p class="text-success">Còn hàng</p>
                                                        @else
                                                            <p class="text-success">Hết hàng</p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('product', $product)}}">Chi tiết</a>
                                                    </td>
                                                    <td class="wishlist_delete">
                                                        <span onclick="confirmDelete({{$product->id}})">Xóa</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="page-home">
                                        <a class="btn btn-default" href="/ ">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            <span>Tiếp tục mua sắm</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    function confirmDelete(product_id){
        Swal.fire({
            title: 'Bạn có muốn xóa sản phẩm này khỏi danh sách yêu thích không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/yeu-thich/delete/${product_id}`;
            }
        })
    }

</script>
@endpush /*php*/
