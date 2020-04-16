<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('overview');
            $table->integer('price')->default(0);
            $table->integer('num_purchase')->default(0);
            $table->integer('level')->default(0);
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('courses_category_id');
            $table->foreign('courses_category_id')->references('id')->on('course_categories');
            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('courses');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
