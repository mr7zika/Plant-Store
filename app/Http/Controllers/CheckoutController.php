<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB; // تمت إضافة هذا السطر للتعامل مع قاعدة البيانات بشكل آمن
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('info', 'السلة فارغة');
        }

        $products = Product::whereIn('id', array_keys($cartItems))->get();
        $total = 0;
        $items = [];

        foreach ($products as $product) {
            $quantity = $cartItems[$product->id];
            $subtotal = $product->price * $quantity; // تم إصلاح علامة الضرب هنا
            $total += $subtotal;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return view('checkout.index', [
            'items' => $items,
            'total' => $total,
            'user' => Auth::user(),
            'isGuest' => !Auth::check(),
        ]);
    }

    /**
     * Process the purchase.
     */
    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('checkout.index')->with('warning', 'يجب عليك تسجيل الدخول لإتمام الشراء.');
        }

        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        $cartItems = $request->session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('products.index')->with('error', 'السلة فارغة');
        }

        // بدء معاملة آمنة مع قاعدة البيانات لمنع تضارب الطلبات في نفس الثانية
        DB::beginTransaction();

        try {
            // جلب المنتجات وقفلها مؤقتاً (lockForUpdate) حتى تنتهي هذه العملية لمنع عميل آخر من شراء نفس القطعة
            $products = Product::whereIn('id', array_keys($cartItems))->lockForUpdate()->get();
            $totalAmount = 0;

            // 1. التحقق النهائي من المخزون قبل الدفع
            foreach ($products as $product) {
                $quantity = $cartItems[$product->id];
                
                // إذا نفدت الكمية أو أصبحت أقل من المطلوب أثناء تواجد العميل في صفحة الدفع
                if ($product->quantity < $quantity) {
                    DB::rollBack(); // التراجع عن أي تغييرات
                    return redirect()->route('cart.view')->with('error', "عذراً، نفدت الكمية المطلوبة من منتج '{$product->name}' أثناء إتمام طلبك. المتاح حالياً هو {$product->quantity} فقط.");
                }
                
                $subtotal = $product->price * $quantity;
                $totalAmount += $subtotal;
            }

            // 2. إنشاء الطلب
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $validated['phone'],
                'customer_address' => $validated['address'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // 3. إضافة العناصر للطلب وخصم المخزون الفعلي
            foreach ($products as $product) {
                $quantity = $cartItems[$product->id];
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // خصم الكمية المباعة من قاعدة البيانات فوراً
                $product->decrement('quantity', $quantity);
            }

            // اعتماد التغييرات في قاعدة البيانات وتفريغ السلة
            DB::commit();
            $request->session()->forget('cart');

            return redirect()->route('profile.index')->with('success', 'تم إتمام الطلب بنجاح! رقم الطلب: #' . $order->id);

        } catch (\Exception $e) {
            DB::rollBack(); // التراجع في حال حدوث أي خطأ برمجي
            return redirect()->route('checkout.index')->with('error', 'حدث خطأ أثناء معالجة الطلب. يرجى المحاولة مرة أخرى.');
        }
    }

    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('checkout.login');
    }

    /**
     * Authenticate user.
     */
    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $guestCart = $request->session()->get('cart', []);

        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => 'البيانات المدخلة غير صحيحة.',
            ]);
        }

        $request->session()->regenerate();

        if (!empty($guestCart)) {
            $request->session()->put('cart', $guestCart);
        }

        return redirect()->route('checkout.index')->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    /**
     * Show registration form.
     */
    public function showRegisterForm(Request $request)
    {
        if ($request->hasCookie('device_registered')) {
            return redirect()->route('checkout.login')
                ->with('warning', 'عذراً، يوجد حساب مسجل من هذا الجهاز بالفعل. يرجى تسجيل الدخول.');
        }

        return view('checkout.register');
    }

    /**
     * Store a new user.
     */
    public function storeUser(Request $request)
    {
        if ($request->hasCookie('device_registered')) {
            return redirect()->route('checkout.login')
                ->with('warning', 'يبدو أن لديك حساباً مسجلاً بالفعل على هذا الجهاز. يرجى تسجيل الدخول بدلاً من إنشاء حساب جديد.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $guestCart = $request->session()->get('cart', []);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if (!empty($guestCart)) {
            $request->session()->put('cart', $guestCart);
        }

        Cookie::queue('device_registered', 'true', 2628000);

        return redirect()->route('checkout.index')->with('success', 'تم إنشاء الحساب وتسجيل الدخول بنجاح!');
    }
}