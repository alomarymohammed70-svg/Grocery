@extends('layouts.app')



@section('title', 'إضافة مورد جديد')
@section('page-title', 'إضافة مورد جديد')
@section('page-description', 'أدخل بيانات المورد الجديد')

@section('content')
    <div class="suppliers-table-container">
        <div class="table-header">
            <h3><i class="fas fa-user-plus"></i> إضافة مورد جديد</h3>
        </div>
        
        <div class="modal-body">
            <form id="supplierForm" action="{{ route('suppliers.store') }}" method="POST" class="supplier-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i> اسم المورد
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name"
                               class="form-control" 
                               placeholder="أدخل اسم المورد"
                               required
                               value="{{ old('name') }}">
                        @error('name')
                            <small class="error-text" style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i> رقم الهاتف
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone"
                               class="form-control" 
                               placeholder="أدخل رقم الهاتف"
                               required
                               value="{{ old('phone') }}">
                        @error('phone')
                            <small class="error-text" style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> البريد الإلكتروني
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email"
                               class="form-control" 
                               placeholder="أدخل البريد الإلكتروني"
                               value="{{ old('email') }}">
                        @error('email')
                            <small class="error-text" style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="tax_number">
                            <i class="fas fa-id-card"></i> الرقم الضريبي
                        </label>
                        <input type="text" 
                               id="tax_number" 
                               name="tax_number"
                               class="form-control" 
                               placeholder="أدخل الرقم الضريبي"
                               value="{{ old('tax_number') }}">
                        @error('tax_number')
                            <small class="error-text" style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="company">
                        <i class="fas fa-building"></i> اسم الشركة (اختياري)
                    </label>
                    <input type="text" 
                           id="company" 
                           name="company"
                           class="form-control" 
                           placeholder="أدخل اسم الشركة"
                           value="{{ old('company') }}">
                </div>
                
                <div class="form-group">
                    <label for="address">
                        <i class="fas fa-map-marker-alt"></i> العنوان
                    </label>
                    <textarea id="address" 
                              name="address"
                              class="form-control" 
                              rows="3"
                              placeholder="أدخل العنوان">{{ old('address') }}</textarea>
                    @error('address')
                        <small class="error-text" style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="status">
                            <i class="fas fa-power-off"></i> الحالة
                        </label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="payment_terms">
                            <i class="fas fa-calendar-alt"></i> شروط الدفع
                        </label>
                        <select id="payment_terms" name="payment_terms" class="form-control">
                            <option value="cash" {{ old('payment_terms', '30days') == 'cash' ? 'selected' : '' }}>نقداً عند الاستلام</option>
                            <option value="7days" {{ old('payment_terms') == '7days' ? 'selected' : '' }}>7 أيام</option>
                            <option value="14days" {{ old('payment_terms') == '14days' ? 'selected' : '' }}>14 يوم</option>
                            <option value="30days" {{ old('payment_terms', '30days') == '30days' ? 'selected' : '' }}>30 يوم</option>
                            <option value="60days" {{ old('payment_terms') == '60days' ? 'selected' : '' }}>60 يوم</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes">
                        <i class="fas fa-sticky-note"></i> ملاحظات (اختياري)
                    </label>
                    <textarea id="notes" 
                              name="notes"
                              class="form-control" 
                              rows="3"
                              placeholder="أدخل أي ملاحظات">{{ old('notes') }}</textarea>
                </div>
                
                <div class="modal-footer">
                    <a href="{{ route('suppliers.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> إلغاء
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection