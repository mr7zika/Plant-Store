<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function addItem(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // التحقق الأول: هل الكمية المطلوبة حالياً أكبر من المخزون؟
        if ($product->quantity < $request->quantity) {
            return redirect()->back()->with('error', "عذراً، الكمية المتاحة حالياً في المخزون هي {$product->quantity} فقط.");
        }

        $cart = $request->session()->get('cart', []);

        // التحقق الثاني: لو العميل عنده المنتج في السلة وبيزود عليه، هل المجموع هيتخطى المخزون؟
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id] + $request->quantity;
            if ($product->quantity < $newQty) {
                return redirect()->back()->with('error', "عذراً، الكمية المتاحة حالياً في المخزون هي {$product->quantity} فقط. (لديك بالفعل {$cart[$product->id]} في سلتك)");
            }
            $cart[$product->id] = $newQty;
        } else {
            $cart[$product->id] = $request->quantity;
        }

        $request->session()->put('cart', $cart);
        return redirect()->route('cart.view')->with('success', "تم إضافة {$product->name} إلى السلة بنجاح!");
    }

    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['success' => true, 'items' => [], 'total' => 0, 'count' => 0]);
        }
        $products = Product::whereIn('id', array_keys($cart))->get();
        $items = [];
        $total = 0;
        $count = 0;
        foreach ($products as $p) {
            $qty = $cart[$p->id];
            $sub = $p->price * $qty; // تم إصلاح علامة الضرب
            $total += $sub;
            $count += $qty;
            $items[] = ['id' => $p->id, 'name' => $p->name, 'price' => $p->price, 'quantity' => $qty, 'subtotal' => $sub];
        }
        return response()->json(['success' => true, 'items' => $items, 'total' => $total, 'count' => $count]);
    }

    public function add(Request $request)
    {
        $v = $request->validate(['product_id' => 'required|integer|exists:products,id', 'quantity' => 'required|integer|min:1']);
        $p = Product::findOrFail($v['product_id']);
        if ($p->quantity < $v['quantity']) {
            return response()->json(['success' => false, 'message' => "عذراً، الكمية المتاحة هي {$p->quantity} فقط.", 'available' => $p->quantity], 400);
        }
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$p->id])) {
            $new = $cart[$p->id] + $v['quantity'];
            if ($p->quantity < $new) {
                return response()->json(['success' => false, 'message' => "عذراً، الكمية المتاحة هي {$p->quantity} فقط.", 'available' => $p->quantity], 400);
            }
            $cart[$p->id] = $new;
        } else {
            $cart[$p->id] = $v['quantity'];
        }
        $request->session()->put('cart', $cart);
        $tot = $this->getTotal($request->session()->get('cart'));
        return response()->json(['success' => true, 'message' => 'تمت الإضافة', 'cart_total' => $tot['total'], 'cart_count' => $tot['count']], 201);
    }

    public function update(Request $request, int $productId)
    {
        $v = $request->validate(['quantity' => 'required|integer|min:0']);
        $cart = $request->session()->get('cart', []);
        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'المنتج غير موجود'], 404);
        }
        $p = Product::findOrFail($productId);
        if ($v['quantity'] === 0) {
            unset($cart[$productId]);
            $request->session()->put('cart', $cart);
            $tot = $this->getTotal($request->session()->get('cart'));
            return response()->json(['success' => true, 'removed_id' => $productId, 'cart_total' => $tot['total'], 'cart_count' => $tot['count']]);
        }
        if ($p->quantity < $v['quantity']) {
            return response()->json(['success' => false, 'message' => "عذراً، الكمية المتاحة هي {$p->quantity} فقط."], 400);
        }
        $cart[$productId] = $v['quantity'];
        $request->session()->put('cart', $cart);
        $tot = $this->getTotal($request->session()->get('cart'));
        return response()->json(['success' => true, 'product' => ['id' => $p->id, 'quantity' => $v['quantity']], 'cart_total' => $tot['total'], 'cart_count' => $tot['count']]);
    }

    public function remove(Request $request, int $productId)
    {
        $cart = $request->session()->get('cart', []);
        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
        unset($cart[$productId]);
        $request->session()->put('cart', $cart);
        $tot = $this->getTotal($request->session()->get('cart'));
        return response()->json(['success' => true, 'cart_total' => $tot['total'], 'cart_count' => $tot['count']]);
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return response()->json(['success' => true, 'items' => [], 'total' => 0, 'count' => 0]);
    }

    private function getTotal(array $cart): array
    {
        if (empty($cart)) {
            return ['total' => 0, 'count' => 0];
        }
        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $count = 0;
        foreach ($products as $p) {
            $qty = $cart[$p->id];
            $total += $p->price * $qty; // تم إصلاح علامة الضرب
            $count += $qty;
        }
        return ['total' => $total, 'count' => $count];
    }
}