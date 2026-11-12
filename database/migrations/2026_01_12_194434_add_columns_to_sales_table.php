<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('invoice_number')->unique()->nullable()->after('id');
            $table->decimal('subtotal', 10, 2)->default(0)->after('customer_id');
            $table->decimal('tax', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total_amount', 10, 2)->default(0)->change();
            $table->decimal('remaining_amount', 10, 2)->default(0)->after('paid_amount');
            $table->decimal('change_amount', 10, 2)->default(0)->after('remaining_amount');
            $table->text('notes')->nullable()->after('change_amount');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number', 'subtotal', 'tax', 
                'remaining_amount', 'change_amount', 'notes'
            ]);
        });
    }
};