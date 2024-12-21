<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class PharamcyController extends Controller{
public function index( Request $request )
{
    $active = $request->query('active');

    $stores = Pharmacy::when($active !== null, function ($query) use ($active) {
        $query->where('active', $active); })->orderBy('created_at' , 'desc')->paginate(10);

    return view('store.index', compact('stores'));

}

/**
 * Show the form for creating a new resource.
 */
public function create()
{
    $users = User::all();
    return view('store.create', compact('users'));

}

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:pharmacies,name',
        'description' => 'required|string|max:500',
        'address' => 'required|string|max:255',
        'phone' => 'required|numeric|digits_between:7,15',
        'email' => 'nullable|email|max:255',
        // 'password' => 'required|string|min:8|confirmed',
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

    // Handle the logo upload if exists
    if ($request->hasFile('logo')) {
        $validated['logo'] = $request->file('logo')->store('logos', 'public');
    }

    // Set default for 'delivers' if not provided
    $validated['delivers'] = $request->input('delivers', 0);
    $validated['password'] ='123456';
    $validated['password']= bcrypt($validated['password']);

    // Create the pharmacy record
    Pharmacy::create($validated);

    // Redirect to the index with success message
    return redirect()->route('store.index')->with('success', 'Pharmacy created successfully!');
}





/**
 * Display the specified resource.
 */
public function show(string $id)
{
    $store = Pharmacy::findOrFail($id);
return view('store.view', compact('store'));
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

public function toggleStatus(string $id , int $visible)
{
    $store = Pharmacy::findorfail($id);

    $store->active = $visible ? 0 : 1;
    $store->save();
    return redirect()->route('store.index');
}
}
