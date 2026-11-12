@extends('layouts.app')



@section('title', 'تفاصيل المورد: ' . $supplier->name)
@section('page-title', 'تفاصيل المورد')
@section('page-description', 'عرض معلومات المورد والمشتريات والمدفوعات')

@section('content')
    <div class="suppliers-table-container">
        <div class="table-header">
            <h3><i class="fas fa-user-tie"></i> تفاصيل المورد: {{ $supplier->name }}</h3>
            <div class="table-actions">
                <a href="{{ route('suppliers.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-right"></i> العودة
                </a>
                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn-primary">
                    <i class="fas fa-edit"></i> تعديل
                </a>
            </div>
        </div>
        
        <div class="modal-body">
            <!-- علامات التبويب -->
            <div class="modal-tabs">
                <button class="modal-tab active" onclick="switchTab('supplier-details', 'info')">
                    <i class="fas fa-info-circle"></i> المعلومات
                </button>
                <button class="modal-tab" onclick="switchTab('supplier-details', 'purchases')">
                    <i class="fas fa-shopping-cart"></i> المشتريات
                </button>
                <button class="modal-tab" onclick="switchTab('supplier-details', 'payments')">
                    <i class="fas fa-money-bill-wave"></i> المدفوعات
                </button>
            </div>
            
            <!-- معلومات المورد -->
            <div id="supplier-details">
                <div id="info-tab" class="modal-content-section active">
                    <div class="supplier-profile">
                        <div class="profile-avatar">
                            {{ getInitials($supplier->name) }}
                        </div>
                        <div class="profile-info">
                            <h3>{{ $supplier->name }}</h3>
                            <div class="profile-details">
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-phone"></i> رقم الهاتف</span>
                                    <span class="detail-value">{{ $supplier->phone }}</span>
                                </div>
                                @if($supplier->email)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-envelope"></i> البريد الإلكتروني</span>
                                    <span class="detail-value">{{ $supplier->email }}</span>
                                </div>
                                @endif
                                @if($supplier->tax_number)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-id-card"></i> الرقم الضريبي</span>
                                    <span class="detail-value">{{ $supplier->tax_number }}</span>
                                </div>
                                @endif
                                @if($supplier->company)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-building"></i> اسم الشركة</span>
                                    <span class="detail-value">{{ $supplier->company }}</span>
                                </div>
                                @endif
                                @if($supplier->address)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> العنوان</span>
                                    <span class="detail-value">{{ $supplier->address }}</span>
                                </div>
                                @endif
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> شروط الدفع</span>
                                    <span class="detail-value">
                                        @switch($supplier->payment_terms)
                                            @case('cash') نقداً عند الاستلام @break
                                            @case('7days') 7 أيام @break
                                            @case('14days') 14 يوم @break
                                            @case('30days') 30 يوم @break
                                            @case('60days') 60 يوم @break
                                            @default {{ $supplier->payment_terms }}
                                        @endswitch
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-power-off"></i> الحالة</span>
                                    <span class="detail-value">
                                        <span class="status-badge {{ $supplier->status === 'active' ? 'active' : 'inactive' }}">
                                            {{ $supplier->status === 'active' ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-calendar"></i> تاريخ الإضافة</span>
                                    <span class="detail-value">{{ $supplier->created_at->format('Y-m-d') }}</span>
                                </div>
                                @if($supplier->notes)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-sticky-note"></i> ملاحظات</span>
                                    <span class="detail-value">{{ $supplier->notes }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="financial-summary">
                        <h4><i class="fas fa-chart-pie"></i> الملخص المالي</h4>
                        <div class="financial-grid">
                            <div class="financial-item">
                                @php
                                    $balanceClass = $supplier->balance > 0 ? 'positive' : ($supplier->balance < 0 ? 'negative' : '');
                                    $balanceText = $supplier->balance > 0 ? 'مدين لنا' : ($supplier->balance < 0 ? 'نحن مدينون' : 'متوازن');
                                @endphp
                                <div class="financial-value {{ $balanceClass }}">
                                    {{ number_format(abs($supplier->balance), 2) }} ر.س
                                </div>
                                <div class="financial-label">{{ $balanceText }}</div>
                            </div>
                            <div class="financial-item">
                                <div class="financial-value">
                                    {{ number_format($supplier->total_purchases ?? 0, 2) }} ر.س
                                </div>
                                <div class="financial-label">إجمالي المشتريات</div>
                            </div>
                            <div class="financial-item">
                                <div class="financial-value">
                                    {{ number_format($supplier->total_paid ?? 0, 2) }} ر.س
                                </div>
                                <div class="financial-label">إجمالي المدفوع</div>
                            </div>
                            <div class="financial-item">
                                <div class="financial-value {{ ($supplier->pending_amount ?? 0) > 0 ? 'negative' : '' }}">
                                    {{ number_format($supplier->pending_amount ?? 0, 2) }} ر.س
                                </div>
                                <div class="financial-label">المتبقي</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- مشتريات المورد -->
                <div id="purchases-tab" class="modal-content-section">
                    <h4><i class="fas fa-shopping-cart"></i> سجل المشتريات</h4>
                    <div class="table-scroll">
                        <table class="purchases-table">
                            <thead>
                                <tr>
                                    <th>رقم الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th>قيمة الفاتورة</th>
                                    <th>المدفوع</th>
                                    <th>المتبقي</th>
                                    <th>حالة الدفع</th>
                                    <th>تاريخ الاستحقاق</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td>#{{ $purchase->id }}</td>
                                        <td>{{ $purchase->date->format('Y-m-d') }}</td>
                                        <td>{{ number_format($purchase->total, 2) }} ر.س</td>
                                        <td>{{ number_format($purchase->paid, 2) }} ر.س</td>
                                        <td>{{ number_format($purchase->remaining, 2) }} ر.س</td>
                                        <td>
                                            @php
                                                $statusClass = '';
                                                $statusText = '';
                                                if($purchase->status == 'paid') {
                                                    $statusClass = 'status-paid';
                                                    $statusText = 'مدفوعة';
                                                } elseif($purchase->status == 'pending') {
                                                    $statusClass = 'status-pending';
                                                    $statusText = 'قيد الانتظار';
                                                } else {
                                                    $statusClass = 'status-overdue';
                                                    $statusText = 'متأخرة';
                                                }
                                            @endphp
                                            <span class="payment-status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>{{ $purchase->due_date->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #8e8e93;">
                                            <i class="fas fa-shopping-cart" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                            <p>لا توجد مشتريات</p>
                                            <small>لم يتم تسجيل أي مشتريات من هذا المورد</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- مدفوعات المورد -->
                <div id="payments-tab" class="modal-content-section">
                    <h4><i class="fas fa-money-bill-wave"></i> سجل المدفوعات</h4>
                    <div class="table-scroll">
                        <table class="payments-table">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>رقم الفاتورة</th>
                                    <th>المبلغ</th>
                                    <th>طريقة الدفع</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->date->format('Y-m-d') }}</td>
                                        <td>#{{ $payment->purchase_id }}</td>
                                        <td>{{ number_format($payment->amount, 2) }} ر.س</td>
                                        <td>
                                            @switch($payment->method)
                                                @case('cash') نقداً @break
                                                @case('transfer') تحويل بنكي @break
                                                @case('check') شيك @break
                                                @default {{ $payment->method }}
                                            @endswitch
                                        </td>
                                        <td>{{ $payment->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: #8e8e93;">
                                            <i class="fas fa-money-bill-wave" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                            <p>لا توجد مدفوعات</p>
                                            <small>لم يتم تسجيل أي مدفوعات لهذا المورد</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function switchTab(containerId, tabName) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // تحديث علامات التبويب
            container.parentElement.querySelectorAll('.modal-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // تحديث المحتوى
            container.querySelectorAll('.modal-content-section').forEach(section => {
                section.classList.remove('active');
            });
            const tabContent = container.querySelector(`#${tabName}-tab`);
            if (tabContent) {
                tabContent.classList.add('active');
            }
        }
    </script>
    @endpush
@endsection