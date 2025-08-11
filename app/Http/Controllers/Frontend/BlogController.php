<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    public function blog(){
        $posts = Post::orderByDesc('id')->paginate(6);
        return view('frontend.blog', compact('posts'));
    }

    public function blogDetail(Post $post){
        $relatedPosts = Post::where('post_type_id', $post->post_type_id)
                            ->where('id', '!=', $post->id)    
                            ->limit(3)->get();
        $post->view +=1;
        $post->save();
        return view('frontend.blog-details', compact('post','relatedPosts'));
    }
}
 /*php*/
