<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forecast_id');
            $table->unsignedInteger('year');
            $table->unsignedInteger('month');
            $table->unsignedInteger('size');
            $table->unsignedInteger('sale');
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
        Schema::dropIfExists('actual_sales');
    }
}
