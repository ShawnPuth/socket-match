<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePkRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pk_record', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('userid_one')->nullable()->comment('');
            $table->unsignedInteger('userid_two')->nullable()->comment('');
            $table->string('questions', 200)->nullable()->comment('本次对战的问题id');
            $table->unsignedInteger('type')->default(0)->comment('1好友对战2排位赛');
            $table->unsignedInteger('leave')->default(0)->comment('1加入2开始3离开');
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
        Schema::dropIfExists('pk_record');
    }
}
