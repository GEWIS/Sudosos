<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragePointofsalePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_pointofsale', function (Blueprint $table) {
            $table->uuid('storage_id');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->uuid('pointofsale_id');
            $table->foreign('pointofsale_id')->references('id')->on('pointsofsales')->onDelete('cascade');
            $table->primary(['storage_id','pointofsale_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('storage_pointofsale');
    }
}
