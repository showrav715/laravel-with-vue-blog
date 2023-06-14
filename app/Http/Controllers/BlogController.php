<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        if(Blog::count() > 0){
            return response(['data'=>BlogResource::collection(Blog::latest()->paginate(10)),'status'=>1]);
        }else{
            return response()->json([
                'status' => 0,
                'data' => 'No data found'
            ], 404);
        }
       
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|unique:blogs,title',
            'image' => 'required|image',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        $title = $request->title;
        $category_id = $request->category_id;
        // create and save post
        $post = new Blog();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('blogs/', $filename);
            $post->image = $filename;
        }
        $post->title = $title;
        $post->category_id = $category_id;
        $post->slug = Str::slug($title);
        $post->user_id = auth()->user()->id;
        $post->body = $request->input('body');
        $post->created_at = now();
        $post->save();

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ], 201);

    }

    public function show($id)
    {
        $post = Blog::findOrFail($id);
        if (auth()->user()->id !== $post->user->id) {
            return abort(403);
        }
        return response(new BlogResource($post));
    }


    public function update(Request $request, $id)
    {
        
       
        $post = Blog::findOrFail($id);
    
        if (auth()->user()->id !== $post->user->id) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required',
             'image' => 'nullable | image',
            'body' => 'required',
            'category_id' => 'required',
        ]);

     
        $title = $request->title;
        $category_id = $request->category_id;

        $slug = Str::slug($title, '-') . '-' . $post->id;
        $body = $request->input('body');

         if ($request->hasFile('image')) {
            unlink('blogs/' . $post->image);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('blogs/', $filename);
            $post->image = $filename;
        }

        // create and save post
        $post->title = $title;
        $post->category_id = $category_id;
        $post->slug = $slug;
        $post->body = $body;
        $post->update();
        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
        ], 201
        );
    }

    public function destroy($id)
    {
        $post = Blog::findOrFail($id);
        if (auth()->user()->id !== $post->user->id) {
            return abort(403);
        }
        unlink('blogs/' . $post->image);
        return $post->delete();
    }
}
