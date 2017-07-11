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
        Schema::create('pointsofsale_storage', function (Blueprint $table) {
            $table->uuid('pointsofsale_id');
            $table->foreign('pointsofsale_id')->references('id')->on('pointsofsales')->onDelete('cascade');
            $table->uuid('storage_id');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->primary(['pointsofsale_id', 'storage_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pointsofsale_storage');
    }
}
