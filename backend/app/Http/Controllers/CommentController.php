<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function index(Request $request)
    {
        // Get the 'approved' filter from the query parameters
        $approved = $request->query('approved');

        // Fetch comments with filtering and pagination
        $comments = Comment::when($approved !== null, function ($query) use ($approved) {
            $query->where('approved', $approved);
        })
            ->with(['user', 'blog']) // Include user and blog relationships
            ->orderBy('id', 'desc')  // Order by descending ID
            ->paginate(10);          // Paginate with 10 comments per page

        // Return the view with comments and the filter value
        return view('comment.index', compact('comments', 'approved'));
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
        $comment= Comment::with('user', 'blog')->find($id);
        return view('comment.show', compact('comment'));
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
    public  function  status(string $id , string $visible){
        $comment= Comment::with('user', 'blog')->find($id);
        $comment->approved= $visible ? 0 : 1;
        $comment->save();
        return redirect()->route('comment.show' ,['id' => $id]);
    }
}
