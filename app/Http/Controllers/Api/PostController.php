<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
     return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required',
        ];
       $validator =  Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
        ],$messages);
        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()], 200);

        }else{
            $post= Post::create([
                'title' => $request->title,
                'description'=> $request->description,
            ]);
            return response()->json(['post' => $post, 'msg' => 'Create Data Successfully'], 200);
        }

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
        return response()->json($post, 200);
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
        $post= Post::find($id);
        $post->update([
            'title'=>$request->title,
            'description'=>$request->description,
        ]);
        return response()->json(['msg'=>'Update Successful'], 200);
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
        $post->delete();
        return response()->json(['DeletedPost'=>$post, 'msg' => 'Delete Successful'], 200);
    }
}
