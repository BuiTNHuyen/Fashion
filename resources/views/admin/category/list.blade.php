@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Danh mục</h5>
                    <a href="{{route('category.create')}}" class="btn btn-primary m-1">Tạo mới</a>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">#</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tên danh mục</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Danh mục cha</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($categories as $category)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $counter++ }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-semibold">{{ $category->name }}</p>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <span class="badge bg-primary">Danh mục gốc</span>
                                    </td>
                                    <td class="border-bottom-0 text-center d-flex justify-content-center">
                                        <a href="{{route('category.edit', $category)}}" class="btn btn-outline-secondary btn-sm m-1">Sửa</a>
                                        <form action="{{route('category.destroy', $category)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')"
                                            type="submit" class="btn btn-outline-danger btn-sm m-1">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                
                                {{-- Hiển thị các danh mục con --}}
                                @foreach($category->children as $child)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $counter++ }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-semibold">
                                                {{ $child->name }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0 text-center">
                                            <p class="mb-0 fw-semibold">{{ $category->name }}</p>
                                        </td>
                                        <td class="border-bottom-0 text-center d-flex justify-content-center">
                                            <a href="{{route('category.edit', $child)}}" class="btn btn-outline-secondary btn-sm m-1">Sửa</a>
                                            <form action="{{route('category.destroy', $child)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')"
                                                type="submit" class="btn btn-outline-danger btn-sm m-1">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($categories->isEmpty())
                    <div class="text-center py-4">
                        <p class="text-muted">Chưa có danh mục nào được tạo.</p>
                        <a href="{{route('category.create')}}" class="btn btn-primary">Tạo danh mục đầu tiên</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection