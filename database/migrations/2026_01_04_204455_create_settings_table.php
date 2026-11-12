<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إذا كان جدول settings موجود من قبل، نضيف الحقول الجديدة فقط
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'store_name')) {
                    $table->string('store_name')->nullable();
                }
                if (!Schema::hasColumn('settings', 'store_phone')) {
                    $table->string('store_phone')->nullable();
                }
                if (!Schema::hasColumn('settings', 'store_email')) {
                    $table->string('store_email')->nullable();
                }
                if (!Schema::hasColumn('settings', 'store_address')) {
                    $table->text('store_address')->nullable();
                }
                if (!Schema::hasColumn('settings', 'currency')) {
                    $table->string('currency')->default('SAR');
                }
                if (!Schema::hasColumn('settings', 'date_format')) {
                    $table->string('date_format')->default('DD/MM/YYYY');
                }
                if (!Schema::hasColumn('settings', 'time_format')) {
                    $table->string('time_format')->default('12h');
                }
                if (!Schema::hasColumn('settings', 'language')) {
                    $table->string('language')->default('ar');
                }
                if (!Schema::hasColumn('settings', 'tax_rate')) {
                    $table->decimal('tax_rate', 5, 2)->default(15.00);
                }
                if (!Schema::hasColumn('settings', 'expiry_warning_days')) {
                    $table->integer('expiry_warning_days')->default(30);
                }
                if (!Schema::hasColumn('settings', 'low_stock_threshold')) {
                    $table->integer('low_stock_threshold')->default(10);
                }
            });
        } else {
            // إنشاء جدول settings إذا لم يكن موجوداً
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('store_name')->nullable();
                $table->string('store_phone')->nullable();
                $table->string('store_email')->nullable();
                $table->text('store_address')->nullable();
                $table->string('currency')->default('SAR');
                $table->string('date_format')->default('DD/MM/YYYY');
                $table->string('time_format')->default('12h');
                $table->string('language')->default('ar');
                $table->decimal('tax_rate', 5, 2)->default(15.00);
                $table->integer('expiry_warning_days')->default(30);
                $table->integer('low_stock_threshold')->default(10);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // لا نقوم بحذف الحقول في حالة التراجع
        // يمكنك إزالة الحقول يدوياً إذا أردت
    }
};