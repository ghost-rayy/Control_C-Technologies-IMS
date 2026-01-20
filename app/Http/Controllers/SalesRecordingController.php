<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SalesRecordingController extends Controller
{
    public function create()
    {
        $products = Product::where('quantity_in_stock', '>', 0)
            ->with('category')
            ->get();

        return view('staff.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:Cash,Mobile Money,Card',
            'transaction_ref' => 'nullable|string|max:255',
        ]);

        // Validate stock availability
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product->quantity_in_stock < $item['quantity']) {
                return back()->with('error', "Insufficient stock for {$product->name}. Available: {$product->quantity_in_stock}");
            }
        }

        // Create sale
        $totalAmount = 0;
        $totalCost = 0;
        $saleItems = [];

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $itemTotal = $product->selling_price * $item['quantity'];
            $itemCost = $product->cost_price * $item['quantity'];

            $totalAmount += $itemTotal;
            $totalCost += $itemCost;

            $saleItems[] = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->selling_price,
                'total_price' => $itemTotal,
                'unit_cost' => $product->cost_price,
            ];
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'total_amount' => $totalAmount,
            'total_cost' => $totalCost,
            'payment_method' => $validated['payment_method'],
            'transaction_ref' => $validated['transaction_ref'] ?? null,
        ]);

        // Create sale items and update stock
        foreach ($saleItems as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                ...$item,
            ]);

            $product = Product::find($item['product_id']);
            $product->decrement('quantity_in_stock', $item['quantity']);
        }

        $routeName = auth()->user()->isAdmin() ? 'admin.sales.receipt' : 'staff.sales.receipt';

        return redirect()->route($routeName, $sale->id)
            ->with('success', 'Sale recorded successfully.');
    }

    public function receipt(Sale $sale)
    {
        // Ensure the sale belongs to the current user or is admin
        if ($sale->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $sale->load('items.product', 'user');

        return view('staff.sales.receipt', compact('sale'));
    }

    public function print(Sale $sale)
    {
        // Ensure the sale belongs to the current user or is admin
        if ($sale->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $sale->load('items.product', 'user');

        return view('staff.sales.print', compact('sale'));
    }

    public function history()
    {
        $sales = Sale::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(15);

        return view('staff.sales.history', compact('sales'));
    }
}
