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
        $this->middleware('auth')->except(['welcome']);
    }

    /**
     * Display a listing of the shoes.
     */
    /**public function welcome()
    {
        $shoes = Shoe::paginate(9); // Paginate to show only 9 shoes per page

        return Inertia::render('Shoes/Index', [
            'shoes' => $shoes,
        ]);
    }*/

    public function index(Request $request)
{
    $shoes = Shoe::paginate(9);

    return Inertia::render('Shoes/Index', [
        'shoes' => $shoes,
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
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('images', 'public');  // Store images in public/images

        // New shoe
        $shoe = new Shoe($request->all());
        $shoe->user_id = Auth::id();
        $shoe->image_path = $imagePath;
        $shoe->save();

        return redirect()->route('shoes.index')->with('success', 'Shoe created successfully');
    }

    /**
     * Show the details of a specific shoe.
     */
    public function show(Shoe $shoe)
    {
        $shoe->increment('view');
    
        return Inertia::render('Shoes/Shoe', [
            'shoe' => $shoe->fresh(),
            'authUser' => Auth::user(),
        ]);
    }

    public function topShoes()
    {
        $topShoes = Shoe::orderBy('view', 'desc')->take(3)->get();

        return $topShoes;
    }

    public function latestShoes()
    {
        $latestShoes = Shoe::orderBy('created_at', 'desc')->take(3)->get();

        return $latestShoes;
    }



}