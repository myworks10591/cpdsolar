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
        Schema::create('customer_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('invoice_no')->unique();
            $table->date('material_dispatch_date_first')->nullable();
            $table->date('material_dispatch_date_second')->nullable();
            $table->string('installer_name');
            $table->date('installation_date')->nullable();
            $table->enum('dcr_certificate', ['Yes', 'No'])->default('No');
            $table->enum('installation_indent', ['Yes', 'No'])->default('No');
            $table->enum('meter_installation', ['Yes', 'No', 'Smart Meter'])->default('No');
            $table->enum('meter_configuration', ['Yes', 'No', 'Selling Certificate'])->default('No');
            $table->string('installation_submission_operator_name');
            $table->enum('subsidy_receive_status_first', ['Yes', 'No'])->default('No');
            $table->enum('subsidy_receive_status_second', ['Yes', 'No'])->default('No');
            $table->enum('warranty_certificate_download', ['Yes', 'No'])->default('No');
            $table->string('warranty_certificate_delivery_operator_name')->nullable();
            $table->date('warranty_certificate_delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_statuses');
    }
};
