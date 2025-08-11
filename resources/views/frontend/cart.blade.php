@extends('frontend.layout.master')
@section('content')
@section('page-class', 'product-cart checkout-cart blog')
@section('page-id', 'cart')

    <div class="main-content" id="cart">
        <!-- main -->
        <div id="wrapper-site">
            <!-- breadcrumb -->
            <nav class="breadcrumb-bg">
                <div class="container no-index">
                    <div class="breadcrumb">
                        <ol>
                            <li>
                                <a href="/">
                                    <span>Home</span>
                                </a>
                            </li>
                            <li>
                                <span>
                                    <span>Giỏ hàng</span>
                                </span>
                            </li>
                        </ol>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 onecol">
                        <section id="main">
                            <div class="cart-grid row">
                                <div class="col-md-9 col-xs-12 check-info">
                                    <h1 class="title-page">Giỏ hàng</h1>
                                    <div class="cart-container">
                                        <div class="cart-overview js-cart">
                                            @if (session('cart'))
                                                <ul class="cart-items">
                                                    @foreach (session('cart') as $cart)
                                                        <li class="cart-item">
                                                            <div class="product-line-grid row justify-content-between">
                                                                <!--  product left content: image-->
                                                                <div class="product-line-grid-left col-md-2">
                                                                    <span class="product-image media-middle">
                                                                        <a href="{{route('product', $cart['product_id'])}}">
                                                                            <img class="img-fluid" src="{{$cart['image']}}" alt="product">
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                                <div class="product-line-grid-body col-md-6">
                                                                    <div class="product-line-info">
                                                                        <a class="label" href="{{route('product', $cart['product_id'])}}" 
                                                                            data-id_customization="0">{{$cart['name']}}</a>
                                                                    </div>
                                                                    <div class="product-line-info product-price">
                                                                        <span class="value">{{convertPrice($cart['price'])}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="product-line-grid-right text-center product-line-actions col-md-4">
                                                                    <div class="row">
                                                                        <div class="col-md-5 col qty">
                                                                            <div class="label">Số lượng:</div>
                                                                            <div class="quantity">
                                                                                <input type="hidden" name="product_id" class="product-id" value="{{$cart['product_id']}}">
                                                                                <input type="text" name="quantity" value="{{$cart['quantity']}}" class="input-group form-control" disabled>
                                                                                <span class="input-group-btn-vertical">
                                                                                    <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-up cart" type="button">
                                                                                        +
                                                                                    </button>
                                                                                    <button class="btn btn-touchspin js-touchspin bootstrap-touchspin-down cart" type="button">
                                                                                        -
                                                                                    </button>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 col price">
                                                                            <div class="label">Tổng tiền:</div>
                                                                            <div class="product-price total">
                                                                                {{convertPrice($cart['quantity'] * $cart['price'])}}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col text-xs-right align-self-end">
                                                                            <div class="cart-line-product-actions ">
                                                                                <span class="remove-from-cart" rel="nofollow" onclick="confirmDelete({{$cart['product_id']}})">
                                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <a href="{{route('checkout')}}" class="continue btn btn-primary pull-xs-right">
                                        Thanh toán
                                    </a>
                                </div>
                                <div class="cart-grid-right col-xs-12 col-lg-3">
                                    <div class="cart-summary">
                                        <div class="cart-detailed-totals">
                                            <div class="cart-summary-products">
                                                <div class="summary-label">Có {{count(session('cart'))}} sản phẩm trong giỏ</div>
                                            </div>
                                            <div class="cart-summary-line cart-total">
                                                <span class="label">Tổng tiền:</span>
                                                <span class="value">{{convertPrice(session('total_price'))}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="block-reassurance">
                                        <ul>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="/assets/frontend/img/product/check1.png" alt="Security policy (edit with Customer reassurance module)">
                                                    <span>Security policy (edit with Customer reassurance module)</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="/assets/frontend/img/product/check2.png" alt="Delivery policy (edit with Customer reassurance module)">
                                                    <span>Delivery policy (edit with Customer reassurance module)</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="/assets/frontend/img/product/check3.png" alt="Return policy (edit with Customer reassurance module)">
                                                    <span>Return policy (edit with Customer reassurance module)</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
<script>
    function confirmDelete(id){
        Swal.fire({
            title: 'Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/cart/delete/' + id;
            }
        })
    }

</script>
@endpush /*php*/
