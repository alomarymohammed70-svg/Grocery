<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة {{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 20px;
        }
        .invoice {
            width: 80mm;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .info {
            margin-bottom: 15px;
        }
        .info div {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .total {
            text-align: left;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <h1>فاتورة بيع</h1>
        </div>
        
        <div class="info">
            <div><strong>رقم الفاتورة:</strong> {{ $sale->id }}</div>
    <div><strong>التاريخ:</strong> {{ date('Y/m/d h:i A', strtotime($sale->sale_date)) }}</div> 
            @if($sale->customer)
                <div><strong>العميل:</strong> {{ $sale->customer->name }}</div>
            @endif
            <div><strong>المستخدم:</strong> {{ $sale->user->name }}</div>
            <div><strong>نوع البيع:</strong> {{ $sale->sale_type == 'cash' ? 'نقدي' : 'دين' }}</div>
            @if($sale->sale_type == 'credit')
                <div><strong>المبلغ المدفوع:</strong> {{ number_format($sale->paid_amount, 2) }} ر.س</div>
                <div><strong>المبلغ المتبقي:</strong> {{ number_format($sale->total_amount - $sale->paid_amount, 2) }} ر.س</div>
            @endif
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>
                        @if($item->product)
                            {{ $item->product->name }}
                        @else
                            {{ 'منتج سريع' }}
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }} ر.س</td>
                    <td>{{ number_format($item->total, 2) }} ر.س</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total">
            <strong>الإجمالي:</strong> {{ number_format($sale->total_amount, 2) }} ر.س
        </div>
        
        <div class="footer">
            <p>شكراً لتعاملك معنا</p>
            <p>{{ config('app.name') }}</p>
            <p>تاريخ الطباعة: {{ now()->format('Y/m/d h:i A') }}</p>
        </div>
        
        <div class="no-print" style="margin-top: 20px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px;">
                🖨️ طباعة الفاتورة
            </button>
            <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; margin-right: 10px;">
                ✖️ إغلاق
            </button>
        </div>
    </div>
    
    <script>
        // طباعة تلقائية عند فتح الصفحة
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>