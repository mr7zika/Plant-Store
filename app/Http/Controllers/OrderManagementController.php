<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    /**
     * تحديث حالة الطلب وخصم المخزون فقط عند التسليم
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        // التحقق: إذا تم تغيير الحالة إلى "تم التسليم" ولم يكن مسلماً من قبل
        if ($validated['status'] === 'delivered' && $order->status !== 'delivered') {
            
            // المرور على جميع منتجات هذا الطلب وخصم كمياتها
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    // خصم الكمية المباعة من المخزون
                    $product->decrement('quantity', $item->quantity); 
                }
            }
        }

        // حفظ الحالة الجديدة للطلب
        $order->update(['status' => $validated['status']]);

        // العودة للصفحة السابقة مع رسالة نجاح
        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }
}