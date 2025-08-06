@extends('admin.layout.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold">Khách hàng</h5>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">ID</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Họ tên</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Email</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Số điện thoại</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Địa chỉ</h6>
                                </th>
                                <th class="border-bottom-0 text-end">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#{{$user->id}}</h6>
                                    </td>
                                    <td class="border-bottom-0 d-flex align-items-center ">
                                        <img class="rounded-circle" style="width: 40px;" src="{{ $user->avatar ?? asset('assets/frontend/img/no-avatar.png')}}" alt="">
                                        <div class="m-2">
                                            <p class="fw-semibold mb-0">{{$user->name}}</p>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$user->email}}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$user->phone}}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$user->address}}</p>
                                    </td>
                                    
                                    <td class="border-bottom-0 text-end">
                                        <a href="{{route('user.destroy', $user)}}" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không?')"
                                        class="btn btn-outline-danger m-1">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection