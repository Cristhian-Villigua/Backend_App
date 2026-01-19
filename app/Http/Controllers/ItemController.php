<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // =======================
    // PÚBLICO
    // =======================

    public function index()
    {
        $items = Item::with('category')->get();
        return response()->json($items, 200);
    }

    public function show($id)
    {
        $item = Item::with('category')->find($id);

        if (!$item) {
            return response()->json(['error' => 'Ítem no encontrado'], 404);
        }

        return response()->json($item, 200);
    }

    // =======================
    // ADMIN
    // =======================

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:100',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'category_id'  => 'required|exists:categories,id',
            'picUrl.*'     => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $pics = [];

        if ($request->hasFile('picUrl')) {
            foreach ($request->file('picUrl') as $img) {
                $pics[] = $img->store('items', 'public');
            }
        }

        $item = Item::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'price'        => $request->price,
            'category_id'  => $request->category_id,
            'picUrl'       => $pics,
        ]);

        return response()->json([
            'message' => 'Ítem creado exitosamente',
            'item'    => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Ítem no encontrado'], 404);
        }

        $request->validate([
            'title'        => 'sometimes|string|max:100',
            'description'  => 'sometimes|string',
            'price'        => 'sometimes|numeric|min:0',
            'category_id'  => 'sometimes|exists:categories,id',
            'picUrl.*'     => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->has('title'))        $item->title = $request->title;
        if ($request->has('description'))  $item->description = $request->description;
        if ($request->has('price'))        $item->price = $request->price;
        if ($request->has('category_id'))  $item->category_id = $request->category_id;

        if ($request->hasFile('picUrl')) {
            $pics = [];
            foreach ($request->file('picUrl') as $img) {
                $pics[] = $img->store('items', 'public');
            }
            $item->picUrl = $pics;
        }

        $item->save();

        return response()->json([
            'message' => 'Ítem actualizado exitosamente',
            'item'    => $item
        ], 200);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['error' => 'Ítem no encontrado'], 404);
        }

        $item->delete();

        return response()->json([
            'message' => 'Ítem eliminado exitosamente'
        ], 200);
    }
}