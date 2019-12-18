<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('type_id')->nullable()->comment('类型id');
            $table->string('question', 100)->nullable();
            $table->string('answer_a', 100)->nullable();
            $table->string('answer_b', 100)->nullable();
            $table->string('answer_c', 100)->nullable();
            $table->string('answer_d', 100)->nullable();
            $table->string('answer', 5)->nullable();
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
        Schema::dropIfExists('question');
    }
}
