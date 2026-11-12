<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * عرض صفحة الموردين
     */
    public function index(Request $request)
    {
        $query = Supplier::withCount('purchases');
        
        // البحث
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }
        
        // الفلترة حسب الحالة
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // الفلترة حسب الرصيد
        if ($request->has('balance') && $request->balance != '') {
            if ($request->balance == 'positive') {
                $query->where('balance', '>', 0);
            } elseif ($request->balance == 'negative') {
                $query->where('balance', '<', 0);
            } elseif ($request->balance == 'zero') {
                $query->where('balance', 0);
            }
        }
        
        // الترتيب
        $query->orderBy('created_at', 'desc');
        
        $suppliers = $query->paginate(20);
        
        // حساب الإحصائيات
        $stats = [
            'total' => Supplier::count(),
            'active' => Supplier::where('status', 'active')->count(),
            'inactive' => Supplier::where('status', 'inactive')->count(),
            'total_debt' => Supplier::where('balance', '>', 0)->sum('balance'),
        ];
        
        return view('suppliers.index', compact('suppliers', 'stats'));
    }
    
    /**
     * عرض نموذج إضافة مورد جديد
     */
    public function create()
    {
        return view('suppliers.create');
    }
    
    /**
     * حفظ مورد جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:suppliers,phone',
            'email' => 'nullable|email|max:255',
            'tax_number' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'payment_terms' => 'required|in:cash,7days,14days,30days,60days',
            'notes' => 'nullable|string',
        ]);
        
        Supplier::create($request->all());
        
        return redirect()->route('suppliers.index')
            ->with('success', 'تم إضافة المورد بنجاح');
    }
    
    /**
     * عرض تفاصيل المورد
     */
    public function show(Supplier $supplier)
    {
        $purchases = Purchase::where('supplier_id', $supplier->id)
            ->orderBy('date', 'desc')
            ->get();
        
        $payments = Payment::where('supplier_id', $supplier->id)
            ->orderBy('date', 'desc')
            ->get();
        
        return view('suppliers.show', compact('supplier', 'purchases', 'payments'));
    }
    
    /**
     * عرض نموذج تعديل المورد
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }
    
    /**
     * تحديث بيانات المورد
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'email' => 'nullable|email|max:255',
            'tax_number' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'payment_terms' => 'required|in:cash,7days,14days,30days,60days',
            'notes' => 'nullable|string',
        ]);
        
        $supplier->update($request->all());
        
        return redirect()->route('suppliers.show', $supplier->id)
            ->with('success', 'تم تحديث بيانات المورد بنجاح');
    }
    
    /**
     * حذف المورد
     */
    public function destroy(Supplier $supplier)
    {
        // التحقق من وجود مشتريات مرتبطة
        if ($supplier->purchases()->exists()) {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف مورد لديه مشتريات مرتبطة');
        }
        
        $supplier->delete();
        
        return redirect()->route('suppliers.index')
            ->with('success', 'تم حذف المورد بنجاح');
    }
    
    /**
     * عرض مشتريات المورد
     */
    public function purchases(Supplier $supplier)
    {
        $purchases = Purchase::where('supplier_id', $supplier->id)
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('suppliers.purchases', compact('supplier', 'purchases'));
    }
    
    /**
     * عرض مدفوعات المورد
     */
    public function payments(Supplier $supplier)
    {
        $payments = Payment::where('supplier_id', $supplier->id)
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('suppliers.payments', compact('supplier', 'payments'));
    }
}