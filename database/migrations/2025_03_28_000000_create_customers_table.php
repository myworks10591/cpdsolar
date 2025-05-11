<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('group_id');
            $table->string('district');
            $table->string('name');
            $table->string('mobile_no');
            $table->string('email')->nullable();
            $table->string('account_no');
            $table->string('jan_samarth_bank_branch');
            $table->string('jan_samarth_ifsc_code');
            $table->string('division');
            $table->string('electric_account_id');
            $table->text('address');
            $table->date('registration_date');
            $table->string('application_reference_no');
            $table->decimal('kw', 8, 2);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_mode');
            $table->date('jan_samarth_date');
            $table->date('document_submission_date');
            $table->timestamps();

            $table->foreign('operator_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}

?>