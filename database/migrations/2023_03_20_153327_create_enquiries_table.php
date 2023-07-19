<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->enum('qualification', [
                'grade-6', 'grade-7', 'grade-8', 'grade-9', 'grade-10', 'grade-11', 'grade-12', 'graduated', 'elementary-student', 'college-student'
            ]);
            $table->integer('time_table_id')->nullable();
            $table->boolean('is_anytime')->default(0);
            $table->enum('enquiry_status', [0, 1, 2])->comment('0 pending, 1 success, 2 cancel');
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
        Schema::dropIfExists('enquiries');
    }
}