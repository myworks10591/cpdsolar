<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('dispatch_number', 50)->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('product_name', 255);
            $table->dateTime('dispatch_date');
            $table->string('driver_name', 100);
            $table->string('van_number', 50);
            $table->string('driver_mobile', 20);
            $table->enum('status', ['Pending', 'Dispatched', 'Delivered', 'Cancelled']);
            $table->foreignId('dispatched_by');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatches');
    }
};
