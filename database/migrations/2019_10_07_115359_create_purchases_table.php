<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_code');
            $table->unsignedInteger('supplier_id');
            $table->decimal('gross_total');
            $table->decimal('discount')->default(0);
            $table->decimal('net_total');
            $table->longText('remarks')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1->unapproved and 2->approved');
            $table->timestamps();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
