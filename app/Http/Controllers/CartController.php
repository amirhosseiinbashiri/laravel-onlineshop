<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // نمایش سبد
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        return view('main.pages.cart.index', compact('cart', 'total'));
    }

    // افزودن به سبد
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'title' => $product->title,
                'quantity' => $request->quantity,
                'price' => $product->discount_price ?? $product->price,
                'main_image' => $product->main_image,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'محصول به سبد اضافه شد.');
    }

    // بروزرسانی تعداد
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return back()->with('success', 'تعداد محصول بروزرسانی شد.');
    }

    // حذف محصول
    public function remove(Product $product)
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'محصول از سبد حذف شد.');
    }
    // پاک کردن کل سبد
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'سبد خرید پاک شد.');
    }
}
