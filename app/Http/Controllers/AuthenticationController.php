<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{
    //
       // $validator = 
       public function register(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required",
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        // $user = User::create($validator->validated());
        $user = User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>bcrypt(request('password'))
        ]);
        $token = $user->createToken('API Token',['select', 'create', 'delete', 'update'])->plainTextToken;
        return response()->json([
            'message' => "Your account has been created",
            'user' => $user,
            'token' => $token
        ],200);
    }
    
     
    public function login(Request $request){
        $credentails = $request->only('email','password');
     
        if(Auth::attempt($credentails)){
            $user = Auth::user();
          
            $token = $user->createToken("API TOKEN")->plainTextToken;
            return response()->json([
                'message'=>'success hx kon!',
                'token'=>$token
            ]);
        }
        return response()->json(['message'=>"Invalid credetail !"],404);
       
    }

    public function logout(Request $request){
        $request ->user()->tokens()->delete();
        return response()->json(['message'=>'logout success !']);
    }
}
