<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignkeysTransactionsSubtransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function($table) {
            $table->foreign('sold_to_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('authorized_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
        });

        Schema::table('subtransactions', function($table) {
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function($table) {
            $table->dropForeign('sold_to_id');
            $table->dropForeign('authorized_id');
//            $table->dropForeign('activity_id');
        });

        Schema::table('subtransactions', function($table) {
            $table->dropForeign('transaction_id');
            $table->dropForeign('product_id');
            $table->dropForeign('storage_id');
        });
    }
}
