@extends('frontend.layout.master')
@section('content')
@section('page-class', 'user-acount')
@section('page-id', 'user-acount')
@push('css')
    <style>
        [class~=user-acount] [class~=btn][class~=btn-primary] {
            margin-top: 0;
            margin-bottom: 0;
        }
        .table td, .table th{
            vertical-align: middle;
        }
        [class~=ratings] label:before{
            font-size: 45px;
            margin: 5.4px;
        }
        [class~=ratings] > input:checked ~ label {
            color: #f7bc3d;
        }
        [class~=ratings] label {
            margin: 0;
        }
        [class~=ratings]{
            margin: 0 101px;
        }
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
                                <span>Tài khoản</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </nav>

        <div class="acount head-acount">
            <div class="container">
                <div id="main">
                    
                    @if (session('success_message'))
                        <div class="alert alert-success" role="alert">{{session('success_message')}}</div>
                    @endif

                    <form action="{{route('account.update')}}" method="POST">
                        @csrf
                        <h1 class="title-page">Thông tin tài khoản</h1>
                        <div class="content" id="block-history">
                            <table class="std table">
                                <tbody>
                                    <tr>
                                        <th class="first_item">Họ tên :</th>
                                        <td>
                                            <span>{{$user->name}}</span>
                                            <div class="form-group mb-0" id="user-name" placeholder="Nhập họ tên" hidden >
                                                <input type="text" name="name" class="form-control" value="{{$user->name}}" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="email">Email :</th>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <th class="first_item">Địa chỉ :</th>
                                        <td>
                                            <span>{{$user->address}}</span>
                                            <div class="form-group mb-0" id="user-address" placeholder="Nhập địa chỉ" hidden>
                                                <input type="type" name="address" class="form-control" value="{{$user->address}}">
                                            </div>
                                        </td>
                                    </tr>
                                
                                    <tr>
                                        <th class="first_item">Số điện thoại :</th>
                                        <td>
                                            <span>{{$user->phone}}</span>
                                            <div class="form-group mb-0" id="user-phone" placeholder="Số điện thoại" hidden>
                                                <input type="type" name="phone" class="form-control" value="{{$user->phone}}">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-primary" id="btn-edit" data-link-action="sign-in" type="button">
                            Sửa thông tin
                        </button>
                        <button class="btn btn-primary" id="btn-update" data-link-action="sign-in" type="submit" hidden>
                            Cập nhật
                        </button>
                    </form>
                    <div class="order">
                        <h4>Lịch sử đặt hàng</h4>
                        @if ($orders->count() == 0)
                            <p>Bạn chưa đặt bất kỳ đơn đặt hàng nào.</p>
                        @else
                            {{-- <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Thời gian</th>
                                        <th scope="col" class="text-center">Phương thức thanh toán</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                        <th scope="col" class="text-right">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">#{{$order->id}}</th>
                                            <td class="text-center">{{date_format($order->created_at, 'd-m-Y H:i:s')}}</td>
                                            <td class="text-center">{{$order->payment == 1 ? 'Ví VNPay' : 'Tiền mặt'}}</td>
                                            @if($order->status == 0)
                                                <td class="text-center"><span class="text-dark">Hủy đơn</span></td>
                                            @elseif($order->status == 1)
                                                <td class="text-center"><span class="text-danger">Trả hàng</span></td>
                                            @elseif($order->status == 2)
                                                <td class="text-center"><span class="text-warning">Chờ xác nhận</span></td>
                                            @elseif($order->status == 3)
                                                <td class="text-center"><span class="text-primary">Đang xử lý</span></td>
                                            @else
                                                <td class="text-center"><span class="text-success">Đã giao hàng</span></td>
                                            @endif
                                            <td class="text-center">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    @if($order->status == 2)
                                                    <form action="{{route('order.cancel', $order)}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary cancel mr-3">Hủy đơn</button>
                                                    </form>
                                                    @elseif($order->status == 3)
                                                    <form action="{{route('order.return', $order)}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger return mr-3">Trả hàng</button>
                                                    </form>
                                                    <form action="{{route('order.receive', $order)}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-info receive mr-3">Nhận hàng</button>
                                                    </form>
                                                    @endif
                                                    <a class="btn btn-primary" data-toggle="collapse" href="#detail-{{$order->id}}" role="button" aria-expanded="false" aria-controls="detail-{{$order->id}}">
                                                        Chi tiết
                                                    </a>
                                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#detail-{{$order->id}}" aria-expanded="true" aria-controls="detail-{{$order->id}}">
                                                        Chi tiết
                                                    </button>
                                                </div>
                                            </td>
                                            <div class="accordion" id="accordion-detail">
                                                <div id="detail-{{$order->id}}" class="collapse"  data-parent="#accordion-detail">
                                                    <div class="card-body">
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                            <div class="accordion" id="order-table">
                                @foreach ($orders as $order)
                                        <div class="card">
                                            <div class="card-header" id="heading{{$order->id}}">
                                                <h6 class="mb-0">
                                                    <div style="width: 100%" >
                                                        <div class="row align-items-center" style="min-height: 38px">
                                                            <div class="col-1">
                                                                <span>#{{$order->id}}</span>
                                                            </div>
                                                            <div class="col-3">
                                                                <span>{{date_format($order->created_at, 'd-m-Y H:i:s')}}</span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>{{strtoupper($order->payment)}}</span>
                                                            </div>
                                                            <div class="col-2">
                                                                @if($order->status == 0)
                                                                    <span class="text-secondary text-center">Đã hủy đơn</span>
                                                                @elseif($order->status == 1)
                                                                    <span class="text-danger text-center">Đã trả hàng</span>
                                                                @elseif($order->status == 2)
                                                                    <span class="text-warning text-center">Chờ xác nhận</span>
                                                                @elseif($order->status == 3)
                                                                    <span class="text-primary text-center">Đang xử lý</span>
                                                                @else
                                                                    <span class="text-success text-center">Đã nhận hàng</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-4">
                                                                <span class="text-center">
                                                                    <div class="d-flex justify-content-end align-items-center">
                                                                        @if($order->status == 2)
                                                                        <form action="{{route('order.cancel', $order)}}" method="POST" id="formCancel">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-secondary cancel mr-3" >Hủy đơn</button>
                                                                        </form>
                                                                        @elseif($order->status == 3)
                                                                        <form action="{{route('order.return', $order)}}" method="POST" id="formReturn">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger return mr-3">Trả hàng</button>
                                                                        </form>
                                                                        <form action="{{route('order.receive', $order)}}" method="POST" id="formReceive">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-info receive mr-3">Nhận hàng</button>
                                                                        </form>
                                                                        @endif
                                                                        <button type="button" class="btn" data-toggle="collapse" href="#order-{{$order->id}}" aria-expanded="false" aria-controls="order-{{$order->id}}">Chi tiết</button>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </h6>
                                            </div>
                                            <div id="order-{{$order->id}}" class="collapse" aria-labelledby="heading{{$order->id}}" data-parent="#order-table">
                                                <div class="card-body" style="padding: 0">
                                                    <table class="align-middle mb-0 table table-borderless border-bottom table-striped ">
                                                        <thead>
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th class="text-center">Số lượng</th>
                                                                <th class="text-center">Đơn giá</th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($order->products as $key=>$item)
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <img src="{{$item->image}}" width="70">
                                                                        <span>{{$item->pivot->name}}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{$item->pivot->quantity}}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{convertPrice($item->pivot->price)}}
                                                                </td>
                                                                <td class="text-center">
                                                                    @if (!isReview($item->pivot->id, $item->pivot->product_id) && $order->status == 4)
                                                                        <button type="button" class="btn btn-light" data-toggle="modal" data-target="#review{{$key}}{{$item->pivot->order_id}}">
                                                                            Đánh giá
                                                                        </button>
                                                                      
                                                                      <!-- Modal -->
                                                                        <div class="modal fade" id="review{{$key}}{{$item->pivot->order_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="exampleModalLabel">Đánh giá sản phẩm: <strong>{{$item->pivot->name}}</strong></h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body pt-0">
                                                                                        <form method="post" action="{{route('review')}}" class="new-review-form">
                                                                                            @csrf
                                                                                            <input type="hidden" name="product_id" value="{{$item->pivot->product_id}}">
                                                                                            <input type="hidden" name="order_product_id" value="{{$item->pivot->id}}">
                                                                                            <div class="spr-form-review-rating">
                                                                                                <fieldset style="float: none" class="ratings mb-2">
                                                                                                    {{-- <input type="radio" id="star10-{{$item->pivot->id}}" name="point" value="10">
                                                                                                    <label class="full" for="star10-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star9-{{$item->pivot->id}}" name="point" value="9">
                                                                                                    <label class="full" for="star9-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star8-{{$item->pivot->id}}" name="point" value="8">
                                                                                                    <label class="full" for="star8-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star7-{{$item->pivot->id}}" name="point" value="7">
                                                                                                    <label class="full" for="star7-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star6-{{$item->pivot->id}}" name="point" value="6">
                                                                                                    <label class="full" for="star6-{{$item->pivot->id}}" title=""></label> --}}
                                                                                                    <input type="radio" id="star5-{{$item->pivot->id}}" name="point" value="5">
                                                                                                    <label class="full" for="star5-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star4-{{$item->pivot->id}}" name="point" value="4">
                                                                                                    <label class="full" for="star4-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star3-{{$item->pivot->id}}" name="point" value="3">
                                                                                                    <label class="full" for="star3-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star2-{{$item->pivot->id}}" name="point" value="2">
                                                                                                    <label class="full" for="star2-{{$item->pivot->id}}" title=""></label>
                                                                                                    <input type="radio" id="star1-{{$item->pivot->id}}" name="point" value="1">
                                                                                                    <label class="full" for="star1-{{$item->pivot->id}}" title=""></label>
                                                                                                </fieldset>
                                                                                            </div>
                                                                                            <div class="spr-form-review-body mb-2">
                                                                                                <textarea style="padding: 10px" class="w-100" name="content" rows="8"></textarea>
                                                                                            </div>
                                                                                            <div class="submit">
                                                                                                <input type="submit" id="submitComment" class="btn btn-default" value="Đánh giá">
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $( document ).ready(function() {
            $("#btn-edit").click(function(){
                $(this).hide();
                $('#btn-update').prop('hidden', false);
                const userAddress = $('#user-address');
                userAddress.prop('hidden', false);
                userAddress.prev().hide();
                const userPhone = $('#user-phone');
                userPhone.prop('hidden', false);
                userPhone.prev().hide();
                const userName = $('#user-name');
                userName.prop('hidden', false);
                userName.prev().hide();
            });

            $('#formCancel').find('button').click(()=>{
                $('#formCancel').submit();
            })
            
            $('#formReturn').find('button').click(()=>{
                $('#formReturn').submit();
            })

            $('#formReceive').find('button').click(()=>{
                $('#formReceive').submit();
            })
        });

    </script>
@endpush /*php*/
