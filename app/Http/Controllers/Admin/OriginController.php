<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\DB;

class OriginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $origins = Origin::orderByDesc('id')->paginate(5);
        return view('admin.origin.list', compact('origins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.origin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:origins,name|string'
        ],[
            'name.required' => 'Vui lòng nhập tên nơi sản xuất.'
        ]);
        DB::beginTransaction();
        try {
            Origin::create($data);
            DB::commit();
            return redirect()->route('origin.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Origin $origin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Origin $origin)
    {
        return view('admin.origin.edit', compact('origin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Origin $origin)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        DB::beginTransaction();
        try {
            $origin->update($data);
            DB::commit();
            return redirect()->route('origin.index');
        } catch (Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Origin $origin)
    {
        $origin->delete();
        return redirect()->back()->with('success', 'Delete successfully!');
    }
}
 /*php*/
