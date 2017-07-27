<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('owner_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $databaseName = DB::connection('mysql_gewisdb')->getDatabaseName();

            $table->primary('id');
            $table->foreign('owner_id')->references('id')->on(new Expression($databaseName . '.Organ'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
