<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the 'active' query parameter and cast to boolean if present
        
        $active = $request->query('active');
        $active = $active === 'true' ? true : ($active === 'false' ? false : null);
        // dd($active);
        // Query users with conditional 'active' filter and role
        $users = User::when($active !== null, function ($query) use ($active) {
            $query->where([
                ['active', $active],
              
            ]);
        })->where(  'role', '=', 'user')->paginate(10); // Adjust pagination as needed
    
        // Return users view with the paginated users
        return view('users', compact('users'));
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
        //
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
    public function update(Request $request, string $id , int $active)
    {
        $user = User::findOrFail($id);
        $user->active = $active ? 0 : 1;
        $user->save();
        return redirect()->route('user.index');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



}
