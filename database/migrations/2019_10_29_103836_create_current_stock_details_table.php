<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentStockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_stock_details', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('current_stock_id');
            $table->integer('product_id');
            $table->string('type');
            $table->date('date');
            $table->integer('quantity');
            $table->string('invoice');
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
        Schema::dropIfExists('current_stock_details');
    }
}
