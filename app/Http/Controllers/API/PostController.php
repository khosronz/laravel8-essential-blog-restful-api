<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Validator;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $posts = Post::all();

        return $this->sendResponse(PostResource::collection($posts),'Posts fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'title'=> 'required|unique:posts|max:255',
            'slug'=> 'required|unique:posts|max:255',
            'body'=> 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error Validation', $validator->errors());
        }

        $post = Post::create($input);

        return $this->sendResponse(new PostResource($post),'Post created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if(is_null($post)){
            return $this->sendError('Post does not exist.');
        }

        return $this->sendResponse(new PostResource($post), 'Post fetched.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        // dd($input);
        $validator = Validator::make($input,[
            'title'=> 'required|max:255',
            'slug'=> 'required|max:255',
            'body'=> 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error Validation', $validator->errors());
        }

        $post = Post::find($id);

        if(is_null($post)){
            return $this->sendError('Post does not exist.');
        }
        

        $post->title=$input['title'];
        $post->slug=$input['slug'];
        $post->body=$input['body'];

        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);


        if(is_null($post)){
            return $this->sendError('Post does not exist.');
        }

        $post->delete();
        return $this->sendResponse([], 'Post deleted.');

    }
}
