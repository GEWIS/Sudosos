<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtransactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('transaction_id');
            $table->uuid('product_id');
            $table->uuid('storage_id');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('price_per_product');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['id', 'transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtransactions');
    }
}
