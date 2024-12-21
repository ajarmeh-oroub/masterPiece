<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductContrller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start the query with eager loading for relationships
        $query = Product::with('reviews', 'discounts');
        
        // Apply filters if they are present in the request
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('sub_category')) {
            $query->where('subcategory_id', $request->sub_category);
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->has('priceRange')) {
            $priceRange = explode('-', $request->priceRange);
            if (count($priceRange) == 2) {
                $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            }
        }
    
        // Fetch the filtered products
        $products = $query->get();
    
        // Add average rating for each product
        $products->transform(function ($product) {
            $averageRating = $product->reviews->avg('rating');
            $product->average_rating = $averageRating ? round($averageRating, 1) : 0;
            return $product;
        });
    
        // Return the response as JSON
        return response()->json($products);
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
    public function storeproduct(Request $request)
    {
        try {
            // Validate the incoming data
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

            // Add additional fields to the validated data
            $validated['created_by_type'] = 'Pharmacy';  // Assuming Admin is from the User model
            $validated['created_by_id'] = 1;  // You can adjust this based on actual user ID

            // Create the product in the database with the validated data
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

            // Flash message for success
            session()->flash('success', 'Product has been added successfully!');

            // Return a JSON response to indicate success
            return response()->json(['message' => 'Product added successfully'], 200);
        } catch (\Exception $e) {
            // Handle the exception (log the error, show a custom error message, etc.)
            Log::error('Error adding product: ' . $e->getMessage());

            // Return a JSON response with error details
            return response()->json([
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['discounts', 'images', 'reviews.user' ,'category'])->findOrFail($id);
    
        // Calculate the average rating from the reviews
        $averageRating = $product->reviews()->avg('rating');
    
        // Add the average rating to the product data
        $product->average_rating = $averageRating ? round($averageRating, 1) : 0;
    
        return response()->json($product);
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

    public function update(Request $request, string $id)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'name' => 'string',
                'price' => 'numeric',
                'stock' => 'numeric',
                'subcategory_id' => 'integer',
                'visible' => 'nullable|boolean',
                'description' => 'string',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'sub_images' => 'nullable|array|max:6',
                'sub_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'warnings' => 'nullable|string',
                'disclaimer' => 'nullable|string',
                'other_ingredients' => 'nullable|string',
                'nutritional_information' => 'nullable|string',
                'brand_id' => 'integer',
                'skin_type' => 'nullable|string',
                'active_ingredients' => 'nullable|string',
                'usage_instructions' => 'nullable|string',
                'bottle_volume' => 'nullable|numeric',
                'bottle_material' => 'nullable|string',
                'bottle_type' => 'nullable|string',
                'cap_type' => 'nullable|string',
            ], [
                // Custom error messages
                'name.required' => 'The product name is required.',
                'price.required' => 'The price is required.',
                'stock.required' => 'The stock quantity is required.',
                'subcategory_id.required' => 'The subcategory is required.',
                'brand_id.required' => 'The brand is required.',
                'main_image.image' => 'The main image must be a valid image file.',
                'main_image.mimes' => 'The main image must be in jpeg, png, or jpg format.',
                'main_image.max' => 'The main image size must not exceed 2MB.',
                'sub_images.max' => 'You can upload up to 6 sub-images.',
                'sub_images.*.image' => 'Each sub-image must be a valid image file.',
            ]);

            // Find the product by ID
            $product = Product::findOrFail($id);

            // Update validated fields
            $validated['created_by_type'] = 'pharmacy'; // Admin type
            $validated['created_by_id'] = 1; // Assuming user ID is 1 for now
            $product->update($validated);

            // Handle Main Image Upload (if provided)
            if ($request->hasFile('main_image')) {
                $file = $request->file('main_image');
                $filePath = $file->store('assets/uploads/products', 'public');
                $product->update(['main_image' => $filePath]);
            }

            // Handle Sub Images Upload (limit to 6 images)
            if ($request->hasFile('sub_images')) {
                // Delete old sub-images
                Product_image::where('product_id', $product->id)->delete();

                // Upload and save new sub-images
                foreach ($request->file('sub_images') as $file) {
                    $filePath = $file->store('assets/uploads/products', 'public');
                    Product_image::create([
                        'product_id' => $product->id,
                        'image' => $filePath,
                    ]);
                }
            }

            // Return success response
            return response()->json(['message' => 'Product updated successfully!'], 200);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating product (ID: ' . $id . '): ' . $e->getMessage());

            // Return error response
            return response()->json([
                'message' => 'An error occurred while updating the product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function toggleStatus(string $id)
    {
        try {
            // Find the product by ID
            $product = Product::findOrFail($id);

            // Toggle the visible status (if it's 1, make it 0; otherwise, make it 1)
            $product->visible = $product->visible ? 0 : 1;

            // Save the updated product
            $product->save();

            // Return success response
            return response()->json(['message' => 'Product visibility toggled successfully!'], 200);
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



    public function getNewArrivals()
    {
        $newArrivals = Product::with('discounts', 'reviews')
            ->where('visible', '1')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
    
        $newArrivals->transform(function ($product) {
            $averageRating = $product->reviews->avg('rating');
            $product->average_rating = $averageRating ? round($averageRating, 1) : 0;
            return $product;
        });
    
   
        return response()->json($newArrivals);
    }
    
    


    public function getBestSeller()
    {
        $bestSeller = Product::with('discounts' , 'reviews')->orderBy('sales_count', 'desc')
            ->where('visible', '1')
            ->limit(12)
            ->get();

            $bestSeller->transform(function ($product) {
                $averageRating = $product->reviews->avg('rating');
                $product->average_rating = $averageRating ? round($averageRating, 1) : 0;
                return $product;
            });
        return response()->json($bestSeller);
    }


    public function getSales()
    {
        // Fetch the first 12 products with their associated discount data
        $sales = Product::with('discounts' , 'reviews')
            ->where('visible', '1') // Optional: Assuming you're only interested in active products
            ->whereHas('discounts')
            ->limit(12)
            ->get();

            $sales->transform(function ($product) {
                $averageRating = $product->reviews->avg('rating');
                $product->average_rating = $averageRating ? round($averageRating, 1) : 0;
                return $product;
            });
        // Check if there are sales, if not return a 404 response
        if ($sales->isEmpty()) {
            return response()->json(['message' => 'No sales found'], 404);
        }

        // Return the sales data as a JSON response
        return response()->json($sales);
    }
}
