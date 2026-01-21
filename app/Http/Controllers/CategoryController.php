<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('items')->get();

        return response()->json($categories);
    }


    public function show($id)
    {
        $category = Category::with('items')->find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json($category);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'sometimes|string|max:100|unique:categories,title'
        ]);

        $category = Category::create([
            'title' => $request->title
        ]);

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'category' => $category
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:100|unique:categories,title,' . $category->id
        ]);

        $category->update([
            'title' => $request->title
        ]);

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'category' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Categoría no encontrada'
            ], 404);
        }

        if ($category->items()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar una categoría con items asociados'
            ], 409);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente'
        ]);
    }
}
