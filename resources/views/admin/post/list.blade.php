@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Thể loại bài viết</h5>
                    <a href="{{route('post.create')}}" class="btn btn-primary m-1">Tạo mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Id</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tiêu đề / Thể loại</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-center">Người đăng</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-center">Ngày đăng</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $key=>$post)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{$key+1}}</h6>
                                    </td>
                                    <td class="border-bottom-0 d-flex align-items-center">
                                        <img class="rounded-1" style="height: 40px" src="{{$post->thumbnail}}" alt="">
                                        <div class="m-2">
                                            <h6 class="fw-semibold mb-1">{{$post->title}}</h6>
                                            <span class="fw-normal">{{$post->postType->name}}</span> 
                                        </div>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{$post->admin->name}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{date_format($post->created_at, 'H:i:s, d/m/Y')}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('post.edit', $post)}}" class="btn btn-outline-secondary m-1">Sửa</a>
                                            <form action="{{route('post.destroy', $post)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này không?')"
                                                type="submit" class="btn btn-outline-danger m-1">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection /*php*/
