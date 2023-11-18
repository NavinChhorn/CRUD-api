<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

// import validator 
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
        // $post = Posts::all();
        $post = Posts::join('users', 'users.id', '=', 'posts.user_id')->get(['posts.title', 'posts.description' ,'users.name']);
        return response()->json(['success'=>true, 'data'=>$post],200);
    }

    public function getPostsFrom($id)
    {
        $posts = User::find($id)->Posts;
        return response()->json(['success'=>true, 'data'=>$posts],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:50',
            'description'=>'required|max:50',
            'user_id'=>'required',

        ]);
        if($validator->fails()){
           
            return $validator->errors();
        }
        else{
            $post = Posts::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'user_id' => $request->input('user_id'),
            ]);
            // return $request;
        
        }
        
        return response()->json(['success'=>true, 'data'=>$post->title],201);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Posts::find($id);
        return response()->json(['success'=>true, 'data'=>$post],200);
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
        $post = Posts::find($id);
        
        $post->update([
            'title' =>$request->input('title'),
            'description' =>$request->input('description'),
        ]);
            // return dd(request('title'));
        return response()->json(['success'=>true, 'data'=>$post],200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        $post->delete();
        return response()->json(['success'=>true, 'message' =>"deleted successfully"],201);
    }

   
}
