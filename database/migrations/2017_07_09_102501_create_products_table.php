<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('owner_id');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->binary('image')->nullable();
            $table->unsignedInteger('tray_size');
            $table->enum('category', ["drink","food","ticket","other"]);
            $table->timestamps();
            $table->softDeletes();

            $databaseName = DB::connection('mysql_gewisdb')->getDatabaseName();

            $table->foreign('owner_id')->references('id')->on(new Expression($databaseName . '.Organ'));
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
