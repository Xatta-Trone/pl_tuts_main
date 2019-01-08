<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('softwares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('author')->nullable();
            $table->string('department_slug')->nullable();
            $table->string('level_term_slug')->nullable();
            $table->integer('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('user_id');
            $table->string('user_type');
            $table->string('post_type')->default('software');
            $table->longText('link');
            $table->string('image')->nullable();
            $table->integer('status');
            $table->longText('custom_message')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('softwares');
    }
}
