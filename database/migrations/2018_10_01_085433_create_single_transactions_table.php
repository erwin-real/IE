<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSingleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('product_id');
            $table->string('name');
            $table->string('type');
            $table->string('desc')->nullable();
            $table->unsignedInteger('quantity');
            $table->double('orig_price', 15, 4);
            $table->double('orig_srp', 15, 4);
            $table->double('total', 15, 4);
            $table->double('capital', 15, 4);
            $table->double('income', 15, 4);
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
        Schema::dropIfExists('single_transactions');
    }
}
