<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->enum('sale_type', ['cash', 'credit']);
            $table->timestamp('sale_date')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
