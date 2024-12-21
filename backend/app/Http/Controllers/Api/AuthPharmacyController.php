<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthPharmacyController extends Controller
{



    public function SignUp(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:pharmacies,name',
                'description' => 'required|string|max:500',
                'address' => 'required|string|max:255',
                'phone' => 'required|numeric|digits_between:7,15',
                'email' => 'required|email|max:255|unique:pharmacies,email',  // Ensure email is unique if provided
                'password' => 'required|string|min:6|confirmed',  // Ensure password confirmation is validated
                'pharm_phone' => 'nullable|numeric|digits_between:7,15',
                'pharm_email' => 'nullable|email|max:255|unique:pharmacies,pharm_email',  // Ensure pharm_email is unique if provided
                'owner_name' => 'nullable|string|max:255',
                'owner_phone' => 'nullable|numeric|digits_between:7,15',
                'owner_email' => 'nullable|email|max:255',
                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180'
            ]);
    
            // Handle the logo upload if exists
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }
    
            // Create a new pharmacy entry in the database
            $pharmacy = Pharmacy::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ,
                'password' => bcrypt($validated['password']),
                'pharm_phone' => $validated['pharm_phone'] ?? null,
                'pharm_email' => $validated['pharm_email'] ?? null,
                'owner_name' => $validated['owner_name'] ?? null,
                'owner_phone' => $validated['owner_phone'] ?? null,
                'owner_email' => $validated['owner_email'] ?? null,
                'facebook' => $validated['facebook'] ?? null,
                'instagram' => $validated['instagram'] ?? null,
                'twitter' => $validated['twitter'] ?? null,
                'logo' => $logoPath,  // Save logo path if exists
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'role' => 'pharmacy'
            ]);
    
            // Create an API token for the pharmacy
            $token = $pharmacy->createToken('Pharmacy Token')->plainTextToken;
    
            // Return the token and pharmacy information
            return response()->json([
                'token' => $token,
                'pharmacy' => $pharmacy,
            ], 200);
    
        } catch (\Exception $e) {
            // Handle exceptions and return error message
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
    




    /////////log in ////////////////////////////////////////
    
    public function login(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:6',
    ]);

    // Find the pharmacy by email
    $pharmacy = Pharmacy::where('email', $validated['email'])->first();

    // Check if the pharmacy exists and verify the password
    if (!$pharmacy) {
        return response()->json(['error' => 'Invalid credentials'], 403);
    }

    // Create a token for the authenticated pharmacy
    $token = $pharmacy->createToken('pharmacy-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'pharmacy' => $pharmacy,
    ], 200);
}





///////////////////log out/////////////////////////////
public function logout(Request $request)
{
    try {
        // Get the authenticated pharmacy user
        $pharmacy = $request->user('pharmacy');  // Use 'pharmacy' guard
        
        // Revoke the current access token
        $pharmacy->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Successfully'
        ], 200);

    } catch (\Exception $e) {
        // Handle error (for example, if token deletion fails)
        return response()->json([
            'message' => 'An error occurred while logging out.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


}
