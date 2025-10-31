<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // باید لاگین باشد
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors('برای ثبت نظر باید وارد حساب کاربری شوید.');
        }

        // باید محصول را خریده باشد (فرض بر وجود جدول orders)
        $hasPurchased = $user->orders()
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->exists();

        if (!$hasPurchased && !$user->is_admin) {
            return back()->withErrors('برای ثبت نظر باید این محصول را خریده باشید.');
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $data['user_id'] = $user->id;
        $data['product_id'] = $product->id;

        Comment::create($data);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد و پس از تأیید نمایش داده می‌شود.');
    }
}
