<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentHasCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_has_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->date('join_date');
            $table->integer('course_id');
            $table->boolean('status')->default(1);
            $table->integer('is_finished')->default(0);
            $table->integer('time_table_id');
            $table->integer('batch_id');
            $table->text('remark')->nullable();
            $table->boolean('is_foc')->default(0);
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
        Schema::dropIfExists('student_has_courses');
    }
}