<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المشتريات | نظام إدارة البقالة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    
    <style>

        /* نفس التنسيقات السابقة مع تعديلات بسيطة */
        body {
            font-family: 'SF Pro Display', sans-serif;
            background-color: #f2f2f7;
            margin: 0;
            padding: 0;
        }
.logout-item{
    width: 100%;
    border: none;
    background: transparent;
    text-align: right;
    cursor: pointer;
}

.logout-item:hover{
    background: rgba(255, 80, 80, 0.12);
}

.logout-item i{
    color: #ff6b6b;
}
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1c1c1e;
            margin-bottom: 5px;
        }
        
        .page-title p {
            color: #8e8e93;
            font-size: 15px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0066ff, #5ac8fa);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.3);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background-color: #fafafa;
            padding: 15px;
            text-align: right;
            font-weight: 600;
            color: #1c1c1e;
            border-bottom: 2px solid #f2f2f7;
        }
        
        table td {
            padding: 15px;
            border-bottom: 1px solid #f2f2f7;
        }
        
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }
        
        .badge-warning {
            background-color: rgba(255, 149, 0, 0.1);
            color: #ff9500;
        }
        
        .badge-danger {
            background-color: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .logout-item{
    width: 100%;
    border: none;
    background: transparent;
    text-align: right;
    cursor: pointer;
}

.logout-item:hover{
    background: rgba(255, 80, 80, 0.12);
}

.logout-item i{
    color: #ff6b6b;
}
        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-view {
            background-color: rgba(0, 102, 255, 0.1);
            color: #0066ff;
        }
        
        .btn-edit {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }
        
        .btn-delete {
            background-color: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
        }
        
        .btn-icon:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div class="page-title">
                <h1>قائمة المشتريات</h1>
                <p>عرض جميع فواتير الشراء</p>
            </div>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                إضافة فاتورة شراء
            </a>
        </div>
        
        <div class="card">
            <table id="purchasesTable">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>المورد</th>
                        <th>التاريخ</th>
                        <th>المبلغ الإجمالي</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->invoice_number }}</td>
                        <td>{{ $purchase->supplier->name }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ number_format($purchase->total, 2) }} ر.س</td>
                        <td>
                            @if($purchase->payment_method == 'cash')
                                نقداً
                            @elseif($purchase->payment_method == 'transfer')
                                تحويل بنكي
                            @else
                                آجل
                            @endif
                        </td>
                        <td>
                            @if($purchase->status == 'completed')
                                <span class="badge badge-success">مكتمل</span>
                            @elseif($purchase->status == 'pending')
                                <span class="badge badge-warning">قيد الانتظار</span>
                            @else
                                <span class="badge badge-danger">ملغي</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="btn-icon btn-view" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn-icon btn-edit" onclick="printInvoice({{ $purchase->id }})" title="طباعة">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="btn-icon btn-delete" onclick="deletePurchase({{ $purchase->id }})" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#purchasesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                },
                order: [[2, 'desc']]
            });
        });
        
        function printInvoice(id) {
            window.open('/purchases/' + id + '/print', '_blank');
        }
        
        function deletePurchase(id) {
            if (confirm('هل أنت متأكد من حذف هذه الفاتورة؟')) {
                fetch('/purchases/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم الحذف بنجاح');
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>