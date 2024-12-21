<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands= Brand::orderBy('created_at' , 'desc')->get();
        return view('brand.index' , compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'image.image' => 'The image must be a file of type: jpeg, png, jpg.',
            'image.max' => 'The image size must be less than 2MB.',
        ]);
    
        // Create the brand instance and set name
        $brand = new Brand;
        $brand->name = $validated['name'];
    
        // Check if image is present before saving
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('assets/uploads/brands', 'public');
            $brand->image = $filePath;
        }
    
       
        $brand->save();
    
        return redirect()->route('brand.index'); 
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand= Brand::findOrFail($id);
        return view('brand.edit' , compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Make image optional
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'image.image' => 'The image must be a file of type: jpeg, png, jpg.',
            'image.max' => 'The image size must be less than 2MB.',
        ]);
    
        // Find the brand by ID or throw a 404
        $brand = Brand::findOrFail($id);
        $brand->name = $validated['name'];
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }
    
            $file = $request->file('image');
            $filePath = $file->store('assets/uploads/brands', 'public');
            $brand->image = $filePath;
        }
    
        // Save updated data
        $brand->save();
    
        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
