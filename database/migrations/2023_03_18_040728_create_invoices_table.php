<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            // 'student_id', 'invoice_ID', 'course_id', 'payment_method'
            $table->id();
            $table->string('invoiceID');
            $table->integer('student_id');
            $table->integer('discount_amount');
            $table->integer('net_pay');
            $table->integer('course_id');
            $table->integer('time_table_id');
            $table->enum('payment_method', [
                'cash', 'k-pay', 'wave-pay'
            ]);
            $table->text('remark')->nullable();
            $table->string('c_by')->nullable();
            $table->string('u_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}