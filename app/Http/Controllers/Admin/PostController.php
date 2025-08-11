<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   

        $posts = Post::orderByDesc('id')->paginate(5);
        return view('admin.post.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $post_types = PostType::all();
        return view('admin.post.create', compact('post_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_type_id' => 'required',
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $post = Post::create([
                'post_type_id' => $request->post_type_id,
                'admin_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
                'view' => 0,
                'thumbnail' => $this->saveImage($request->thumbnail),
            ]);
            
            DB::commit();
            return redirect()->route('post.index');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function saveImage($image){
        $imageName = $image->hashName();
        $res = $image->storeAs('thumbnail', $imageName, 'public');
        if($res){
            $path = 'thumbnail/'. $imageName;
        } 
        return $path;

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.Post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $post_types = PostType::all();
        return view('admin.post.edit', compact('post','post_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_type_id' => 'required',
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            $post->post_type_id = $request->post_type_id;
            $post->title = $request->title;
            $post->content = $request->content;
            if($request->file('thumbnail')){
                $post->thumbnail = $this->saveImage($request->thumbnail);
            }
            $post->save();
            DB::commit();
            return redirect()->route('post.index');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Xóa bài viết thành công!');
    }
} /*php*/
