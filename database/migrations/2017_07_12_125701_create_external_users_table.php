<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('password');
            $table->string('legacy_password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('external_users');
    }
}
