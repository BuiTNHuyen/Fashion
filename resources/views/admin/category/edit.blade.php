@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Danh mục</h5>
                <form method="POST" action="{{route('category.update', $category)}}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" name="name" value="{{$category->name}}" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="parent" class="form-label">Danh mục cha
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="parent_id" id="parent">
                            <option value="" disabled selected>--- Chọn danh mục cha ---</option>
                            <option {{$category->parent_id == 0 ? 'selected' : ''}} value="0">Danh mục gốc</option>
                            @foreach ($parent_cates as $parent_cate)
                                <option {{$category->parent_id == $parent_cate->id ? 'selected' : ''}} value="{{$parent_cate->id}}">{{$parent_cate->name}}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection /*php*/
