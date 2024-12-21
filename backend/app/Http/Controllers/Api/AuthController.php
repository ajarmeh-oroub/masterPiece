<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


  public function index(){
$user=User::all();
return response()->json($user);
  }
    public function SignUp(Request $request)
    {
      try{
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'first_name.required' => 'The first name field is required.',
            'first_name.string' => 'The first name must be a valid string.',
            'first_name.max' => 'The first name must not exceed 255 characters.',
        
            'last_name.required' => 'The last name field is required.',
            'last_name.string' => 'The last name must be a valid string.',
            'last_name.max' => 'The last name must not exceed 255 characters.',
        
            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a valid string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'email.unique' => 'This email address is already registered.',
        
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least 6 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::create([
            'password' => bcrypt($validated['password']),
            'email' => $validated['email'],
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'role'=>'user'
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);}
        catch(Exception $e){
          return response()->json(['error'=>$e->getMessage()],403);
        }
    }




    /////////log in ////////////////////////////////////////
    public function login(Request $request){
      $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:6',
    ], [
        
        'email.required' => 'The email field is required.',
        'email.string' => 'The email must be a valid string.',
        'email.email' => 'Please enter a valid email address.',
      
    
    
        'password.required' => 'The password field is required.',
        'password.string' => 'The password must be a valid string.',
        'password.min' => 'The password must be at least 6 characters long.',
    ]);

    $creds= ['email'=>$validated['email'], 'password'=>$validated['password'] ];

try{
  if(!auth()->attempt($creds)){
    return response()->json(['error'=>'Invalid credentials'], 403);
  }
$user = User::where('email' , '=' , $validated['email'])->firstOrFail();
$token = $user->createToken('token')->plainTextToken;
return response()->json([
  'token' => $token,
  'user' => $user,
], 200);

}catch(Exception $e){
  return response()->json(['error'=>$e->getMessage()], 403);
}
    }




///////////////////log out/////////////////////////////
public function logout(Request $request){
$request->user()->currentAccessToken()->delete();
return response()->json([
 'message'=>'Logged Out Successfully'
], 200);
}

}
