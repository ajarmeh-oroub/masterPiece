<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $approved = $request->query('approved');
        $reviews = Review::when($approved !== null, function ($query) use ($approved) {
            $query->where('approved', $approved);
        })
        ->orderBy('id' , 'desc')
        ->with('user')
        ->paginate(10); 

        return view('review.index' , compact('reviews'));
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
        $review = Review::with('user' , 'product')->findOrFail($id);
        return view('review.show' , compact('review'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function status(string $id, string $visible){
        $review = Review::findOrFail($id);
        $review->approved = $visible ? 0 : 1;
        $review->save();
        return redirect()->route('review.show', ['id' => $id]);
    }
}
