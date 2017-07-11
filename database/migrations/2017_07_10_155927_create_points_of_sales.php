<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsOfSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pointsofsales', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('owner_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pointsofsales');
    }
}
