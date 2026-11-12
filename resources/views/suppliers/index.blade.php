@extends('layouts.app')

@section('title', 'الموردين')
@section('page-title', 'الموردين')
@section('page-description', 'إدارة موردي المتجر ومتابعة المشتريات والمدفوعات')
@section('top-bar-actions')
@endsection

@section('content')


<div class="top-bar">
                <div class="page-title">
                    <button class="mobile-menu-btn" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1>الموردين</h1>
                        <p>إدارة موردي المتجر ومتابعة المشتريات والمدفوعات</p>
                    </div>
                </div>
                
                <div class="top-bar-actions">
                    <button class="btn-add"  onclick="window.location.href='{{ route('suppliers.create') }}'">
                        <i class="fas fa-user-plus"></i>
                        إضافة مورد جديد
                    </button>
                </div>

                
            </div>
    <!-- إحصائيات الموردين -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-header">
                <div>
                    <div class="stat-value" id="totalSuppliers">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label">إجمالي الموردين</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card active">
            <div class="stat-header">
                <div>
                    <div class="stat-value" id="activeSuppliers">{{ $stats['active'] ?? 0 }}</div>
                    <div class="stat-label">الموردين النشطين</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card debt">
            <div class="stat-header">
                <div>
                    <div class="stat-value" id="totalDebt">{{ number_format($stats['total_debt'] ?? 0, 2) }} ر.س</div>
                    <div class="stat-label">إجمالي المديونية</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card inactive">
            <div class="stat-header">
                <div>
                    <div class="stat-value" id="inactiveSuppliers">{{ $stats['inactive'] ?? 0 }}</div>
                    <div class="stat-label">الموردين غير النشطين</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- البحث والتحكم -->
    <div class="controls">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="ابحث عن مورد بالاسم أو الهاتف أو الشركة...">
        </div>
        
        <div class="filter-controls">
            <select class="filter-select" id="statusFilter">
                <option value="">جميع الحالات</option>
                <option value="active">نشط</option>
                <option value="inactive">غير نشط</option>
            </select>
            <select class="filter-select" id="balanceFilter">
                <option value="">جميع الأرصدة</option>
                <option value="positive">مدين لنا</option>
                <option value="negative">نحن مدينون</option>
                <option value="zero">متوازن</option>
            </select>
        </div>
    </div>
    
    <!-- جدول الموردين -->
    <div class="suppliers-table-container">
        <div class="table-header">
            <h3><i class="fas fa-list"></i> قائمة الموردين</h3>
            <div class="table-info">
                <span id="suppliersCount">{{ $suppliers->total() }} مورد</span>
            </div>
        </div>
        
        <div class="table-scroll">
            <table class="suppliers-table">
                <thead>
                    <tr>
                        <th>المورد</th>
                        <th>رقم الهاتف</th>
                        <th>الحالة</th>
                        <th>الرصيد</th>
                        <th>عدد المشتريات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="suppliersTableBody">
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>
                                <div class="supplier-info">
                                    <div class="supplier-avatar">
                                        {{ getInitials($supplier->name) }}
                                    </div>
                                    <div class="supplier-details">
                                        <h4>{{ $supplier->name }}</h4>
                                        <p>{{ $supplier->phone }}</p>
                                        @if($supplier->company)
                                            <p><small><i class="fas fa-building"></i> {{ $supplier->company }}</small></p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $supplier->phone }}</td>
                            <td class="status-cell">
                                <span class="status-badge {{ $supplier->status === 'active' ? 'active' : 'inactive' }}">
                                    {{ $supplier->status === 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="balance-cell">
                                @php
                                    $balanceStatus = $supplier->balance > 0 ? 'positive' : ($supplier->balance < 0 ? 'negative' : 'zero');
                                    $balanceText = $supplier->balance > 0 ? number_format($supplier->balance, 2) . ' ر.س' : 
                                                 ($supplier->balance < 0 ? number_format(abs($supplier->balance), 2) . ' ر.س' : 'متوازن');
                                @endphp
                                <span class="balance-badge {{ $balanceStatus }}" title="{{ $supplier->balance > 0 ? 'مدين لنا' : ($supplier->balance < 0 ? 'نحن مدينون' : 'متوازن') }}">
                                    {{ $balanceText }}
                                </span>
                            </td>
                            <td>
                                <span class="purchases-count">
                                    <i class="fas fa-shopping-cart"></i> {{ $supplier->purchases_count ?? 0 }} عملية
                                </span>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn-action btn-details" onclick="window.location.href='{{ route('suppliers.show', $supplier->id) }}'" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-edit" onclick="window.location.href='{{ route('suppliers.edit', $supplier->id) }}'" title="تعديل البيانات">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المورد؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="حذف المورد">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #8e8e93;">
                                <div class="empty-state">
                                    <i class="fas fa-truck"></i>
                                    <p>لا توجد موردين</p>
                                    <small>ابدأ بإضافة مورد جديد</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- الترقيم -->
        @if($suppliers->hasPages())
            <div class="pagination-container" style="padding: 20px; text-align: center;">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const balanceFilter = document.getElementById('balanceFilter');
            
            function filterSuppliers() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const balanceValue = balanceFilter.value;
                
                const rows = document.querySelectorAll('#suppliersTableBody tr');
                let visibleCount = 0;
                
                rows.forEach(row => {
                    let show = true;
                    
                    // البحث
                    if (searchTerm) {
                        const text = row.textContent.toLowerCase();
                        if (!text.includes(searchTerm)) {
                            show = false;
                        }
                    }
                    
                    // فلترة حسب الحالة
                    if (show && statusValue) {
                        const statusBadge = row.querySelector('.status-badge');
                        if (statusBadge) {
                            const isActive = statusBadge.classList.contains('active');
                            if ((statusValue === 'active' && !isActive) || 
                                (statusValue === 'inactive' && isActive)) {
                                show = false;
                            }
                        }
                    }
                    
                    // فلترة حسب الرصيد
                    if (show && balanceValue) {
                        const balanceBadge = row.querySelector('.balance-badge');
                        if (balanceBadge) {
                            const hasPositive = balanceBadge.classList.contains('positive');
                            const hasNegative = balanceBadge.classList.contains('negative');
                            const hasZero = balanceBadge.classList.contains('zero');
                            
                            if ((balanceValue === 'positive' && !hasPositive) ||
                                (balanceValue === 'negative' && !hasNegative) ||
                                (balanceValue === 'zero' && !hasZero)) {
                                show = false;
                            }
                        }
                    }
                    
                    row.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });
                
                // تحديث العداد
                document.getElementById('suppliersCount').textContent = visibleCount + ' مورد';
            }
            
            // إضافة مستمعي الأحداث
            searchInput.addEventListener('input', filterSuppliers);
            statusFilter.addEventListener('change', filterSuppliers);
            balanceFilter.addEventListener('change', filterSuppliers);
            
            // فلترة أولية
            filterSuppliers();
        });
    </script>
    @endpush
@endsection