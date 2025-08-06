<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $parent_cates = Category::where('parent_id', 0)->get();
        view()->share('parent_cates', $parent_cates);
    }

    public function index(Request $request)
    {
        $query = Category::with(['children', 'products']);
        
        // Tìm kiếm theo tên danh mục
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('children', function($childQuery) use ($search) {
                      $childQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Lấy tất cả danh mục gốc (parent_id = 0) với các danh mục con
        $categories = $query->where('parent_id', 0)
            ->orderBy('name')
            ->get();
            
        // Lấy tổng số danh mục để hiển thị
        $totalCategories = Category::count();
        $parentCategories = Category::where('parent_id', 0)->count();
        $childCategories = Category::where('parent_id', '>', 0)->count();
        
        return view('admin.category.list', compact('categories', 'totalCategories', 'parentCategories', 'childCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories,name|string',
            'parent_id' => 'required|integer',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'parent_id.required' => 'Vui lòng nhập chọn danh mục cha.',
        ]);
        DB::beginTransaction();
        try {
            Category::create($data);
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Thêm thành công!');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'required|integer',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'parent_id.required' => 'Vui lòng nhập chọn danh mục cha.',
        ]);
        DB::beginTransaction();
        try {
            $category->update($data);
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Cập nhật thành công!');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Xóa thành công!');
    }
}
