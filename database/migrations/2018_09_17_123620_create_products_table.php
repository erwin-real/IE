<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('desc')->nullable();
            $table->double('price', 15, 4);
            $table->double('srp', 15, 4);
            $table->string('sold_by');
            $table->string('source')->nullable();
            $table->string('contact')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->unsignedInteger('stocks');
            $table->unsignedInteger('procurement');
            $table->string('cover_image');
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
        Schema::dropIfExists('products');
    }
}
