<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Era;
use App\Models\Pharmacy;
use App\Models\Product_image;
use App\Models\Sub_category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filter parameters from the request
        $storeId = $request->input('pharmacy_id'); // Example filter for store
        $searchQuery = $request->input('search'); // Example filter for search keyword

        // Query with relationships, filters, and pagination
        $products = Product::with(['pharmacy', 'images'])
            ->when($storeId, function ($query, $storeId) {
                return $query->where('store_id', $storeId); // Filter by store
            })
            ->when($searchQuery, function ($query, $searchQuery) {
                return $query->where('name', 'like', "%$searchQuery%"); // Filter by name or other searchable fields
            })
            ->orderBy('created_at', 'desc') // Sort by latest created
            ->paginate(10); // Paginate with 10 products per page

        // Pass filter values to the view to maintain the state
        $stores = Pharmacy::all();
        return view('product.product', compact('products', 'storeId', 'searchQuery', 'stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $stores = Pharmacy::all();
        $subcategories = Sub_category::all();
        $brands = Brand::all();

        return view('product.create', compact('categories', 'stores', 'subcategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'subcategory_id' => 'required|integer',
            'visible' => 'nullable|boolean',
            'description' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sub_images' => 'nullable|array|max:6',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'warnings' => 'nullable|string',
            'disclaimer' => 'nullable|string',
            'other_ingredients' => 'nullable|string',
            'nutritional_information' => 'nullable|string',
            'brand_id' => 'required|integer',
            'skin_type' => 'nullable|string',
            'active_ingredients' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'bottle_volume' => 'nullable|numeric',
            'bottle_material' => 'nullable|string',
            'bottle_type' => 'nullable|string',
            'cap_type' => 'nullable|string',
        ], [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'stock.required' => 'The stock quantity is required.',
            'stock.numeric' => 'The stock quantity must be a valid number.',
            'subcategory_id.required' => 'The subcategory is required.',
            'subcategory_id.integer' => 'The subcategory must be a valid ID.',
            'visible.boolean' => 'The visible field must be true or false.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'main_image.required' => 'The main image is required.',
            'main_image.image' => 'The main image must be an image file.',
            'main_image.mimes' => 'The main image must be a jpeg, png, or jpg file.',
            'main_image.max' => 'The main image must not exceed 2MB.',
            'sub_images.array' => 'Sub images must be an array.',
            'sub_images.max' => 'You can upload a maximum of 6 sub-images.',
            'sub_images.*.image' => 'Each sub-image must be an image file.',
            'sub_images.*.mimes' => 'Each sub-image must be a jpeg, png, or jpg file.',
            'sub_images.*.max' => 'Each sub-image must not exceed 2MB.',
            'warnings.string' => 'Warnings must be a valid text.',
            'disclaimer.string' => 'Disclaimer must be a valid text.',
            'other_ingredients.string' => 'Other ingredients must be a valid text.',
            'nutritional_information.string' => 'Nutritional information must be a valid text.',
            'brand_id.required' => 'The brand is required.',
            'brand_id.integer' => 'The brand must be a valid ID.',
            'skin_type.string' => 'Skin type must be a valid text.',
            'active_ingredients.string' => 'Active ingredients must be a valid text.',
            'usage_instructions.string' => 'Usage instructions must be a valid text.',
            'bottle_volume.numeric' => 'Bottle volume must be a valid number.',
            'bottle_material.string' => 'Bottle material must be a valid text.',
            'bottle_type.string' => 'Bottle type must be a valid text.',
            'cap_type.string' => 'Cap type must be a valid text.',
        ]);
    
        // Get the currently authenticated user
        $user = auth()->user();
            $validated['created_by_type'] = 'Admin'; // Admin is from the User model
            $validated['created_by_id'] = $user->id;
      
    //dd($validated);
        // Create the product with the additional fields
        $product = Product::create($validated);
    
        // Handle Main Image Upload
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filePath = $file->store('assets/uploads/products', 'public');
            $product->main_image = $filePath;
            $product->save();
        }
    
        // Handle Sub Images Upload (limit to 6)
        if ($request->hasFile('sub_images')) {
            foreach ($request->file('sub_images') as $file) {
                $filePath = $file->store('assets/uploads/products', 'public');
                Product_image::create([
                    'product_id' => $product->id,
                    'image' => $filePath,
                ]);
            }
        }
        session()->flash('success', 'Product has been added successfully!');

        // Redirect back to the product index page
        return redirect()->route('product.index');  }
    
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'pharmacy', 'images' , 'brand' ])->find($id);


        return view('product.view', [
            'product' => $product,
            'categories' => $product->category->name,
            'pharmacy' => $product->store,
            'images' => $product->images,
            'brand'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['category', 'images' , 'brand'])->find($id);

        // Get all categories and stores
        $categories = Sub_category::all();
        $stores = Pharmacy::all();
        $brand=Brand::all();
        
        // $eras = Era::all();

        return view('product.edit', [
            'product' => $product,
            'categories' => $categories,  // Pass the list of categories
            'stores' => $stores,
              'brands'=>$brand
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'subcategory_id' => 'required|integer',
            'visible' => 'nullable|boolean',
            'description' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sub_images' => 'nullable|array|max:6',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'warnings' => 'nullable|string',
            'disclaimer' => 'nullable|string',
            'other_ingredients' => 'nullable|string',
            'nutritional_information' => 'nullable|string',
            'brand_id' => 'required|integer',
            'skin_type' => 'nullable|string',
            'active_ingredients' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'bottle_volume' => 'nullable|numeric',
            'bottle_material' => 'nullable|string',
            'bottle_type' => 'nullable|string',
            'cap_type' => 'nullable|string',
        ], [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'stock.required' => 'The stock quantity is required.',
            'stock.numeric' => 'The stock quantity must be a valid number.',
            'subcategory_id.required' => 'The subcategory is required.',
            'subcategory_id.integer' => 'The subcategory must be a valid ID.',
            'visible.boolean' => 'The visible field must be true or false.',
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'main_image.required' => 'The main image is required.',
            'main_image.image' => 'The main image must be an image file.',
            'main_image.mimes' => 'The main image must be a jpeg, png, or jpg file.',
            'main_image.max' => 'The main image must not exceed 2MB.',
            'sub_images.array' => 'Sub images must be an array.',
            'sub_images.max' => 'You can upload a maximum of 6 sub-images.',
            'sub_images.*.image' => 'Each sub-image must be an image file.',
            'sub_images.*.mimes' => 'Each sub-image must be a jpeg, png, or jpg file.',
            'sub_images.*.max' => 'Each sub-image must not exceed 2MB.',
            'warnings.string' => 'Warnings must be a valid text.',
            'disclaimer.string' => 'Disclaimer must be a valid text.',
            'other_ingredients.string' => 'Other ingredients must be a valid text.',
            'nutritional_information.string' => 'Nutritional information must be a valid text.',
            'brand_id.required' => 'The brand is required.',
            'brand_id.integer' => 'The brand must be a valid ID.',
            'skin_type.string' => 'Skin type must be a valid text.',
            'active_ingredients.string' => 'Active ingredients must be a valid text.',
            'usage_instructions.string' => 'Usage instructions must be a valid text.',
            'bottle_volume.numeric' => 'Bottle volume must be a valid number.',
            'bottle_material.string' => 'Bottle material must be a valid text.',
            'bottle_type.string' => 'Bottle type must be a valid text.',
            'cap_type.string' => 'Cap type must be a valid text.',
        ]);
    
        // Find the product by ID and update it with validated data
        $product = Product::findOrFail($id);
        $validated['created_by_type'] = 'Admin'; // Admin is from the User model
        $validated['created_by_id'] = auth()->user()->id;
    
        // Update the product
        $product->update($validated);
    
        // Handle Main Image Upload (only if a new image is uploaded)
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filePath = $file->store('assets/uploads/products', 'public');
            $product->main_image = $filePath;
            $product->save();
        }
    
        // Handle Sub Images Upload (limit to 6 images)
        if ($request->hasFile('sub_images')) {
            // Delete any old sub-images before adding new ones (optional)
            Product_image::where('product_id', $product->id)->delete();
    
            foreach ($request->file('sub_images') as $file) {
                $filePath = $file->store('assets/uploads/products', 'public');
                Product_image::create([
                    'product_id' => $product->id,
                    'image' => $filePath,
                ]);
            }
        }
    
        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }
    
    
    public function updateStatus(Request $request, string $id, string $status)
    {

        $prodct = Product::findorfail($id);
        $prodct->visible = $status ? 0 : 1;
        $prodct->save();
        session()->flash('success', 'Product has been updated successfully!');

        // Redirect back to the product index page
        return redirect()->route('product.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
