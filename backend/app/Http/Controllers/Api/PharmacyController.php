<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
     
      

        // Get pharmacies with their products
        $pharmacies = Pharmacy::all();

        return response()->json($pharmacies );
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
        try{
            $pharmacy= Pharmacy::findOrFail($id);
              return response()->json(['message' => 'pharmacy displayed successfully!'  , $pharmacy], 200);
            }catch (\Exception $e) {
                // Log the error
                Log::error('Error retrieving user data' . $e->getMessage());
        
                // Return error response
                return response()->json([
                    'message' => 'Error retrieving user data.',
                    'error' => $e->getMessage(),
                ], 500);
            }
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
        try{
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'string|max:255|unique:pharmacies,name,' . $id,
            'description' => 'string|max:500',
            'address' => 'string|max:255',
            'phone' => 'numeric|digits_between:7,15',
            'email' => 'email|max:255',
            'pharm_phone' => 'nullable|numeric|digits_between:7,15',
            'pharm_email' => 'nullable|email|max:255',
            'owner_name' => 'nullable|string|max:255',
            'owner_phone' => 'nullable|numeric|digits_between:7,15',
            'owner_email' => 'nullable|email|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'delivers' => 'boolean',
        ]);
    
        // Find the pharmacy by ID
        $pharmacy = Pharmacy::findOrFail($id);
    
        // Handle the logo upload if exists and update the logo field
        if ($request->hasFile('logo')) {
            // Delete the old logo file if it exists
            if ($pharmacy->logo) {
                Storage::delete('public/' . $pharmacy->logo);
            }
            // Store the new logo
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }
    
        // Update the pharmacy record
        $pharmacy->update($validated);
    
        // Redirect to the index with success message
        return response()->json(['message' => 'pharmacy displayed successfully!'  , $pharmacy], 200);
    }catch (\Exception $e) {
        // Log the error
        Log::error('Error retrieving user data' . $e->getMessage());

        // Return error response
        return response()->json([
            'message' => 'Error retrieving user data.',
            'error' => $e->getMessage(),
        ], 500);
    }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function deactivate(string $id)
    {
        try{
        $pharmacy= Pharmacy::findOrFail($id);
        $pharmacy->active=0;
        return response()->json(['message' => 'pharmacy deleted successfully!'  , $pharmacy], 200);
        }catch (\Exception $e) {
            // Log the error
            Log::error('Error retrieving user data' . $e->getMessage());
    
            // Return error response
            return response()->json([
                'message' => 'Error retrieving user data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function toggleDelivery($id){
        try {
            // Find the product by ID
            $pharmacy = Pharmacy::findOrFail($id);
    
            // Toggle the visible status (if it's 1, make it 0; otherwise, make it 1)
            $pharmacy->delivers =  $pharmacy->delivers ? 0 : 1;
    
            // Save the updated product
            $pharmacy ->save();
    
            // Return success response
            return response()->json(['message' => 'Delivery status updated!'], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error toggling product visibility (ID: ' . $id . '): ' . $e->getMessage());
    
            // Return error response
            return response()->json([
                'message' => 'An error occurred while toggling the product visibility.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }
}
