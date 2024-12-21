<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sub_category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->with('sub_category')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Ensure name is required and a string
            'is_parent' => 'nullable|boolean', // Ensure 'is_parent' is a boolean or nullable
        ], [
            // Custom validation messages
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'is_parent.boolean' => 'The parent category field must be true or false.',
        ]);
    
        // Create a new category
        $category = new Category();
        $category->name = $validated['name']; // Assign the validated name
        $category->is_parent = $validated['is_parent'] ?? false; // Set 'is_parent' if provided, default to false if not
    
        // Save the category
        $category->save();
    
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
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
        $category= Category::findorfail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, string $id)
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|string|max:255', // Name is required and must be a string
        'is_parent' => 'nullable|boolean',  // 'is_parent' is optional and must be a boolean
    ], [
        // Custom validation messages
        'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name may not be greater than 255 characters.',
        'is_parent.boolean' => 'The parent category field must be true or false.',
    ]);

    // Find the existing category by ID
    $category = Category::findOrFail($id);

    // Update the category with validated data
    $category->name = $validated['name']; // Assign the validated name
    $category->is_parent = $validated['is_parent'] ?? false; // Set 'is_parent' if provided, default to false if not

    // Save the updated category
    $category->save();

    // Redirect back with success message
    return redirect()->route('category.index')->with('success', 'Category updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function sub_delete($id){
        $subcategory=Sub_category::find($id);
        $subcategory->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }


    public function sub_edit($id){
        $subcategory= Sub_category::findorfail($id);
        $categories=Category::all();
        return view('category.editSub', compact('subcategory' , 'categories'));
    }

    public function sub_update($id, Request $request)
    {
        // Find the subcategory by ID
        $subcategory = Sub_category::findOrFail($id);
    
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Ensure the category exists in the database

        ]);
    
        // Update the subcategory data
        $subcategory->name = $validated['name'];
        $subcategory->category_id = $validated['category_id'];
    
    
        // Save the updated subcategory
        $subcategory->save();
    
        // Redirect with a success message
        return redirect()->route('category.index')->with('success', 'Subcategory updated successfully!');
    }
}
