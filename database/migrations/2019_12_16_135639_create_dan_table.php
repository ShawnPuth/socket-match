<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dan', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('dan_id')->comment('段位ID');
            $table->unsignedInteger('season')->comment('赛季id');
            $table->string('name')->comment('名称');
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
        Schema::dropIfExists('dan');
    }
}
