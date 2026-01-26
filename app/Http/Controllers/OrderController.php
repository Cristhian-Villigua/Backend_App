<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $cliente = $request->user(); 
        
        $orders = Order::where('cliente_id', $cliente->id)
            ->with(['items.item'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio' => 'required|numeric',
            'subTotal' => 'required|numeric',
            'impuesto' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $cliente = $request->user();

        try {
            DB::beginTransaction();

            $order = Order::create([
                'cliente_id' => $cliente->id,
                'subtotal' => $request->subTotal,
                'impuesto' => $request->impuesto,
                'total' => $request->total,
                'status' => 'Pendiente',
            ]);

            foreach ($request->items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $itemData['id'],
                    'quantity' => $itemData['cantidad'],
                    'price' => $itemData['precio'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Orden creada exitosamente',
                'order' => $order->load('items')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al crear la orden: ' . $e->getMessage()], 500);
        }
    }

    public function pendingOrders()
    {
        $orders = Order::whereIn('status', ['Pendiente', 'En Preparacion'])
            ->with(['items.item', 'cliente'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json($orders);
    }

    public function history(Request $request)
    {
        $query = Order::whereIn('status', ['Completado', 'Entregado', 'Cancelado']);

        if ($request->date === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        }

        $orders = $query->with(['items.item', 'cliente'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Estado actualizado', 'order' => $order]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return response()->json(['message' => 'Orden eliminada']);
    }
}
