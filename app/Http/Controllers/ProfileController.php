<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    /**
     * عرض صفحة البروفايل الخاصة بالمستخدم
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get();

        return view('profile', compact('user', 'orders'));
    }

    /**
     * إلغاء الطلب (حذفه وإرجاع المخزون تلقائياً)
     */
    public function cancelOrder(Order $order)
    {
        // التحقق من أن الطلب يخص المستخدم الحالي لأسباب أمنية
        if ($order->user_id !== Auth::id()) {
            abort(403, __('messages.msg_unauthorized_order_cancel'));
        }

        // حذف الطلب (سيقوم تلقائياً بتشغيل الـ booted وإرجاع الكميات للمخزون)
        $order->delete();

        return redirect()->route('profile.index')->with('success', __('messages.msg_order_cancelled_success'));
    }

    /**
     * تسجيل خروج المستخدم
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with('success', __('messages.msg_logout_success'));
    }
}