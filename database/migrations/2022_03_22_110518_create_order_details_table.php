<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('order_id') -> nullable();
            $table -> unsignedBigInteger('item_id') -> nullable();
            $table -> unsignedBigInteger('quantity');
            $table -> timestamps();
            $table -> softDeletes();
            $table -> foreign('order_id') -> references('id') -> on('orders') -> onDelete('set null');
            $table -> foreign('item_id') -> references('id') -> on('products') -> onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
