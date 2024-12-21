<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Article::orderBy('created_at', 'desc')->with('user')->get();
        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define custom validation messages
        $customMessages = [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
            'image.required' => 'An image is required to upload.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'video.url' => 'The video must be a valid URL.',
        ];

        // Validate the incoming request with custom messages
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'video' => 'nullable|url',
        ], $customMessages); // Pass custom messages here

        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $image = $request->file('image');

            // Generate a unique filename for the image
            $fileName = time() . '_' . $image->getClientOriginalName();

            // Store the image in the 'uploads' folder within 'public' disk
            $filePath = $image->storeAs('uploads', $fileName, 'public');

            // Add the image path to the validated data
            $validated['image'] = $filePath;
        }

        if ($request->has('video')) {
            $validated['video'] = $request->input('video');
        }

        // Assign the current authenticated user as the author
        $validated['author_id'] = auth()->id();

        // Create the blog post with the validated data
        Article::create($validated);

        // Redirect to the blog index page
        return redirect()->route('blog.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $blog = Article::with('user')->findOrFail($id);
            return view('blog.show', compact('blog'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Blog not found');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Article::with('user')->findOrFail($id);
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $customMessages = [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
            'image.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'image.max' => 'The image size must not exceed 2MB.',
            'video.url' => 'The video must be a valid URL.',
        ];

        // Validate the incoming request data with custom messages
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpeg,jpg,png|max:2048', // Max 2MB size
            'video' => 'nullable|url',
        ], $customMessages); // Pass custom messages here


        $blog = Article::findOrFail($id);


        if ($request->hasFile('image')) {

            $image = $request->file('image');


            $fileName = time() . '_' . $image->getClientOriginalName();


            $filePath = $image->storeAs('uploads', $fileName, 'public');


            $validated['image'] = $filePath;


            if ($blog->image) {
                \Storage::disk('public')->delete($blog->image);
            }
        }

        if ($request->has('video')) {
            $validated['video'] = $request->input('video');
        }

        // Update the blog with the validated data
        $blog->update($validated);

        // Redirect back to the blog details page
        return redirect()->route('blog.show', $blog->id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog= Article::findorfail($id);
        $blog->delete();
        return redirect()->route('blog.index');
    }
}
