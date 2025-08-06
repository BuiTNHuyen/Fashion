@extends('admin.layout.master')

@section('content')

@if (Auth::guard('admin')->user()->role === 'Quản trị viên')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Nhân viên</h5>
                <form action="{{route('staff.update', $staff)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$staff->name}}">
                        @error('name')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" name="email" id="email" value="{{$staff->email}}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Chức vụ</label>
                        <select name="role" id="role" class="form-select">
                            <option value="" disabled>--- Chọn chức vụ ---</option>
                            <option value="Quản trị viên" {{$staff->role === 'Quản trị viên' ? 'selected' : ''}}>Quản trị viên</option>
                            <option value="Nhân viên" {{$staff->role === 'Nhân viên' ? 'selected' : ''}}>Nhân viên</option>
                        </select>
                        @error('role')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid text-center ">
        <h3>Trang này chỉ dành cho quản trị viên.</h3>
    </div>
@endif

@endsection