<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index', [
            'items' => Item::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('items.create', [
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:80',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|uuid|exists:categories,id',
            'image' => 'image'
        ]);

        $validated['id'] = \Illuminate\Support\Str::uuid();

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->storeAs('item-images', $validated['id']);
        }

        Item::create($validated);

        return redirect('/items')->with('success', 'New item has been created!');
    }

    public function edit($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'message' => 'Item not found',
            ], 404);
        }

        $categories = Category::orderBy('name')->get();

        return view('items.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:80',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|uuid|exists:categories,id',
            'image' => 'image'
        ], [
            'category_id.uuid' => 'You must select one category'
        ]);

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('item-images');
        }

        Item::where('id', $id)->update($validated);

        return redirect('/items')->with('success', 'Item has been updated!');
    }

    public function destroy($id)
    {
        Item::destroy($id);
        return redirect('/items')->with('success', 'Item has been deleted!');
    }
}
