<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::with('comments' , 'orders.orderItems','reviews' ,'address')->findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            
            $user = User::findOrFail($id);
    
            // Validate the incoming data
            $validated = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
                'phone'=>'numeric',
                'password' => 'nullable|string|min:6|confirmed',
            ], [
                'first_name.required' => 'The first name field is required.',
                'first_name.string' => 'The first name must be a valid string.',
                'first_name.max' => 'The first name must not exceed 255 characters.',
            
                // 'last_name.required' => 'The last name field is required.',
                'last_name.string' => 'The last name must be a valid string.',
                'last_name.max' => 'The last name must not exceed 255 characters.',
            
                // 'email.required' => 'The email field is required.',
                'email.string' => 'The email must be a valid string.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'The email must not exceed 255 characters.',
                'email.unique' => 'This email address is already registered.',
            
                'password.string' => 'The password must be a valid string.',
                'password.min' => 'The password must be at least 6 characters long.',
                'password.confirmed' => 'The password confirmation does not match.',
            ]);
    
          
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                 'phone'=>$validated['phone'],
                'password' => isset($validated['password']) ? bcrypt($validated['password']) : $user->password,
            ]);
    
          
            $token = $user->createToken('token')->plainTextToken;
    
           
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function updateAddress(Request $request, $id)
    {
        try {
            // Find the user and load the related address
            $user = User::with('address')->findOrFail($id);
    
            // Validate the incoming request
            $validated = $request->validate([
                'address' => 'required|string|max:255',
                'longitude' => 'nullable|numeric',
                'latitude' => 'nullable|numeric',
            ]);
    
            // Update the user's address
            $user->address->update([
                'address' => $validated['address'],
                'longitude' => $validated['longitude'] ?? $user->address->longitude,
                'latitude' => $validated['latitude'] ?? $user->address->latitude,
            ]);
    
            return response()->json(['message' => 'Address updated successfully'], 200);
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    
}
