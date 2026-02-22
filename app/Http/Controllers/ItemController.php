<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::where('status', 'available');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->get();

        return view('webshop.webshop', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->file('image')->store('items', 'public');

        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
            'status' => 'available'
        ]);

        return redirect()->back();
    }

    public function create()
    {
        return view('webshop.add');
    }
}
