<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentID')->nullable();
            $table->string('name');
            $table->string('nrc')->nullable();
            $table->date('dob')->nullable();
            $table->string('father_name');
            $table->enum('qualification', [
                'grade-6', 'grade-7', 'grade-8', 'grade-9', 'grade-10', 'grade-11', 'grade-12', 'graduated', 'elementary-student', 'college-student'
            ]);
            $table->string('nationality')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->text('address');
            $table->string('qr_filename')->nullable();
            $table->boolean('status')->default(1);
            $table->string('photo')->nullable();
            $table->boolean('is_delete')->default(0);
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
        Schema::dropIfExists('students');
    }
}