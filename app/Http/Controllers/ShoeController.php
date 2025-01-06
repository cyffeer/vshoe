<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shoe;
use Inertia\Inertia;

class ShoeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome']); // Protect actions to ensure user is authenticated
    }

    /**
     * Display a listing of the shoes.
     */

     public function welcome()
    {
        $shoes = Shoe::paginate(9); // Paginate to show only 9 shoes per page

        return Inertia::render('Welcome', [
            'shoes' => $shoes,
        ]);
    }
    public function index(Request $request)
    {
        $shoesQuery = Shoe::with('user'); // Fetch shoes with user relation
        
        // Optionally filter by user_id if it's passed
        if ($request->input('user_id')) {
            $shoesQuery->whereHas('user', function ($query) use ($request) {
                $query->where('id', 'like', $request->input('user_id') . '%');
            });
        }
    
        // Paginate the shoes and pass to the view
        $shoes = $shoesQuery->paginate(9); // Paginate to show only 9 shoes per page
    
        return Inertia::render('Shoes/Index', [
            'shoes' => $shoes, // Pass the shoes data to the Vue component
            'authUser' => Auth::user(), // Pass the authenticated user data
        ]);
    }


    /**
     * Show the form for creating a new shoe.
     */
    public function create()
    {
        return Inertia::render('Shoes/Create');
    }

    /**
     * Store a newly created shoe in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer',
            'quantity' => 'required|integer',
            'quality' => 'required|string|max:255',
            'view' => 'required|integer',
            'price' => 'required|decimal:0,2',
            'brand' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // image validation
        ]);
    
        // Handle image upload
        $imagePath = $request->file('image')->store('images', 'public');  // Store images in public/images
    
        // New shoe
        $shoe = new Shoe($request->all());
        $shoe->user_id = Auth::id(); 
        $shoe->image_path = $imagePath;  // Store image path in database
        $shoe->save();
    
        return redirect()->route('shoes.index')->with('success', 'Shoe created successfully');
    }
    

    /**
     * Show the form for editing the specified shoe.
     */
    public function edit(Shoe $shoe)
    {
        // Ensure only the owner can edit the shoe
        if ($shoe->user_id !== Auth::id()) {
            return redirect()->route('shoes.index')->with('error', 'You cannot edit this shoe.');
        }

        return Inertia::render('Shoe/Edit', [
            'shoe' => $shoe,
        ]);
    }

    /**
     * Update the specified shoe in storage.
     */
    public function update(Request $request, Shoe $shoe)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer',
            'quantity' => 'required|integer',
            'quality' => 'required|string|max:255',
            'view' => 'required|integer',
            'price' => 'required|decimal:0,2',
            'brand' => 'required|string|max:255',
        ]);

        // Ensure only the owner can update the shoe
        if ($shoe->user_id !== Auth::id()) {
            return redirect()->route('shoes.index')->with('error', 'Unauthorized');
        }

        $shoe->update($request->all());

        return redirect()->route('shoes.index')->with('success', 'Shoe updated successfully');
    }

    /**
     * Remove the specified shoe from storage.
     */
    public function destroy(Shoe $shoe)
    {
        // Ensure only the owner can delete the shoe
        if ($shoe->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $shoe->delete();

        return redirect()->back()->with('success', 'Shoe deleted successfully');
    }

    /**
     * Show the details of a specific shoe.
     */
   
    public function show(Shoe $shoe)
    {
    return Inertia::render('Shoes/Shoe', [
        'shoe' => $shoe,
        'authUser' => Auth::user(),
    ]);
    }
}
