<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('shop.index', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id','quantity' => 'nullable|integer|min:1']);
        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);
        $id = (int) $request->product_id;
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Added to cart.');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        return view('shop.checkout', compact('cart', 'products'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->withErrors('Cart is empty');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total = 0;
        foreach ($cart as $pid => $qty) {
            $prod = $products->get($pid);
            if (!$prod) continue;
            $total += $prod->price * $qty;
        }

        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'total' => $total,
        ]);

        foreach ($cart as $pid => $qty) {
            $prod = $products->get($pid);
            if (!$prod) continue;
            Purchase::create([
                'order_id' => $order->id,
                'product_id' => $pid,
                'quantity' => $qty,
                'price' => $prod->price,
            ]);
        }

        session()->forget('cart');
        return redirect()->route('shop.thankyou', $order->id);
    }

    public function thankyou(Order $order)
    {
        return view('shop.thankyou', compact('order'));
    }
}
