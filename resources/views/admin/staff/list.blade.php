@extends('admin.layout.master')

@section('content')

@if (Auth::guard('admin')->user()->role === 'Quản trị viên')
    <div class="container-fluid">
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title fw-semibold">Nhân viên</h5>
                    <form class="product-search d-flex">
                        <input type="text" class="border border-1 border-primary rounded px-2" value="{{request('name')}}"
                        placeholder="Tên nhân viên" name="name" style="margin-right: 10px">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <a href="{{route('staff.create')}}" class="btn btn-primary m-1">Tạo mới</a>
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
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Chức vụ</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Ngày tạo</h6>
                                </th>
                                <th class="border-bottom-0 text-end">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffs as $staff)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#{{$staff->id}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$staff->name}}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{$staff->email}}</p>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <p class="fw-semibold mb-0">{{$staff->role}}</p>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <p class="fw-semibold mb-0">{{date_format($staff->created_at, 'd/m/Y')}}</p>
                                    </td>
                                    
                                    <td class="border-bottom-0 text-end">
                                        <a href="{{route('staff.edit', $staff)}}" class="btn btn-outline-primary m-1">Sửa</a>
                                        <a href="{{route('staff.destroy', $staff)}}" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không?')"
                                        class="btn btn-outline-danger m-1">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{$staffs->links()}}
                </div>
            </div>
        </div>
    </div>
    </div>
@else
    <div class="container-fluid text-center ">
        <h3>Trang này chỉ dành cho quản trị viên.</h3>
    </div>
@endif

@endsection