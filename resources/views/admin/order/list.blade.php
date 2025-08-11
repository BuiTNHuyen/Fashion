@extends('admin.layout.master')

@section('content')

<div class="container-fluid" style="max-width: 1400px">
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold">Đơn hàng</h5>
                    <form action="" style="width: 25%">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option {{ request('status') == '' ? 'selected' : ''}} value="">Tất cả đơn hàng</option>
                            <option {{ request('status') == '0' ? 'selected' : ''}} value="0">Đơn hàng đã hủy</option>
                            <option {{ request('status') == '1' ? 'selected' : ''}} value="1">Đơn hàng đã trả</option>
                            <option {{ request('status') == '2' ? 'selected' : ''}} value="2">Đơn hàng chờ xác nhận</option>
                            <option {{ request('status') == '3' ? 'selected' : ''}} value="3">Đơn hàng đang xử lý</option>
                            <option {{ request('status') == '4' ? 'selected' : ''}} value="4">Đơn hàng đã nhận</option>
                        </select>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">ID</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tên khách hàng</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Địa chỉ</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Số điện thoại</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Phương thức thanh toán</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Tổng tiền</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#{{$order->id}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$order->name}}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$order->address}}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$order->phone}}</p>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <p class="fw-semibold mb-0">{{strtoupper($order->payment)}}</p>
                                    </td>
                                    @if($order->status == 0)
                                        <td class="border-bottom-0 text-center"><span class="badge bg-dark rounded-3 fw-semibold">Hủy đơn</span></td>
                                    @elseif($order->status == 1)
                                        <td class="border-bottom-0 text-center"><span class="badge bg-danger rounded-3 fw-semibold">Trả hàng</span></td>
                                    @elseif($order->status == 2)
                                        <td class="border-bottom-0 text-center"><span class="badge bg-warning rounded-3 fw-semibold">Chờ xác nhận</span></td>
                                    @elseif($order->status == 3)
                                        <td class="border-bottom-0 text-center"><span class="badge bg-info rounded-3 fw-semibold">Đang xử lý</span></td>
                                    @else
                                        <td class="border-bottom-0 text-center"><span class="badge bg-success rounded-3 fw-semibold">Đã giao hàng</span></td>
                                    @endif
                                    <td class="border-bottom-0 text-center">
                                        <p class="fw-semibold mb-0">{{convertPrice($order->total_price)}}</p>
                                    </td>
                                    <td class="border-bottom-0 text-end">
                                        @if ($order->status === 2)
                                            <a href="{{route('order.confirm', $order)}}" class="btn btn-outline-success m-1">Xác nhận</a>
                                        @endif
                                        <a href="{{route('order.show', $order)}}" class="btn btn-outline-info m-1">Chi tiết</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection /*php*/
