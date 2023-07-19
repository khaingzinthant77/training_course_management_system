<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('course_id');
            $table->string('major_ids');
            $table->boolean('is_taken')->default(0);
            $table->dateTime('taken_date')->nullable();
            $table->string('given_by')->nullable();
            $table->string('generate_by')->nullable();
            $table->text('remark')->nullable();
            $table->text('taken_remark')->nullable();
            $table->string('taken_by');
            $table->boolean('is_delete')->default(0);
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
        Schema::dropIfExists('certificates');
    }
}
