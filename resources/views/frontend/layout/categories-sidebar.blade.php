<div class="sidebar-block">
    <div class="title-block">Danh mục</div>
    <div class="block-content">
        @foreach ($categories as $key=>$category)
            <div class="cateTitle hasSubCategory open level1">
                <span class="arrow collapse-icons collapsed" data-toggle="collapse" data-target="#cate-{{$key}}" >
                    <i class="zmdi zmdi-minus"></i>
                    <i class="zmdi zmdi-plus"></i>
                </span>
                <a class="cateItem" href="{{route('category', $category)}}">{{$category->name}}</a>
                <div class="subCategory collapse" id="cate-{{$key}}" aria-expanded="true" role="status">
                    @foreach ($category->children as $child_cate)
                        <div class="cateTitle">
                            <a href="{{route('category', $child_cate)}}" class="cateItem">{{$child_cate->name}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div> /*php*/
