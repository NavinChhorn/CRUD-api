<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:25',
            'email'=>'required|max:55',
            'password'=>'required',
        ]);
        if($validator->fails()){
           
            return $validator->errors();
        }
        else{
            $password = $request->input('password'); // password is form field
            $hashed = Hash::make($password);
            $user = User::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'password'=>$hashed
            ]);
        }
        return response()->json(['success'=>true,'data'=>$user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        // get all 
        // $user = User::all();

        return response()->json(['success'=>true,'user'=>$user],200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
       

    }

  
    public function update(Request $request, string $id)
    {
        
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',

        ]);

        if($validator->fails()){
           
            return $validator->errors();
        }
        else{
            $user = User::find($id);

            $password = $request->input('password'); 
            $hashed = Hash::make($password);

            $user->update([
                'name'=>$request->Input('name'),
                'email'=>$request->input('email'),
                'password'=> $hashed
            ]);
        }
        return response()->json(['success'=>true,'data'=>$user]);
    }

    
    public function destroy(string $id)
    {
        //
        $user=User::find($id);
        $user->delete();
        return response()->json(['success'=>true,'message'=>'user already delete !'],200);
    }
}
