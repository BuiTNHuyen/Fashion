@extends('admin.layout.master')

@section('content')

<div class="container-fluid" style="max-width: 1400px">

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
    @endif
    
    <div class="row">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-4">Sản phẩm</h5>
                    <form class="product-search d-flex">
                        <input type="text" class="border border-1 border-primary rounded px-2" value="{{request('product_code')}}"
                        placeholder="Mã sản phẩm" name="product_code" style="margin-right: 10px">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                    <a href="{{route('product.create')}}" class="btn btn-primary m-1">Tạo mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Thứ tự</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tên / Danh mục</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Mã sản phẩm</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Giảm giá (%)</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Giá bán</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Số lượng</h6>
                                </th>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">Đã bán</h6>
                                </th>
                                <th class="border-bottom-0 text-end">
                                    <h6 class="fw-semibold mb-0">Hành động</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key=>$product)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{$key+1}}</h6>
                                    </td>
                                    <td class="border-bottom-0 d-flex align-items-center">
                                        @php $firstImage = $product->firstImage(); @endphp
                                        <img class="rounded-1" style="width: 40px" src="{{$firstImage ? asset($firstImage->image) : asset('assets/admin/images/products/default.png')}}" alt="">
                                        <div class="m-2">
                                            <h6 class="fw-semibold mb-1">{{$product->name}}</h6>
                                            <span class="fw-normal">{{$product->category->name}}</span> 
                                        </div>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{$product->product_code}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{($product->discount)}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{convertPrice($product->price)}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{$product->quantity}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-center">
                                        <h6 class="fw-semibold mb-0">{{$product->sold}}</h6>
                                    </td>
                                    <td class="border-bottom-0 text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <a href="{{route('product.edit', $product)}}" class="btn btn-outline-warning m-1">Sửa</a>
                                            <form action="{{route('product.destroy', $product)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')"
                                                 type="submit" class="btn btn-outline-danger m-1">Xóa</button>
                                            <a href="{{route('product.show', $product)}}" class="btn btn-outline-info m-1">Chi tiết</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection