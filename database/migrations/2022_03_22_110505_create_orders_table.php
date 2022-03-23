<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('user_id') -> nullable();
            // $table -> unsignedBigInteger('delivery_address_id') -> nullable();
            $table -> string('address_line_1');
            $table -> string('address_line_2');
            $table -> string('city');
            $table -> string('state');
            $table -> string('country');
            $table -> string('pin_code', 6);
            $table -> timestamps();
            $table -> softDeletes();
            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('set null');
            // $table -> foreign('delivery_address_id') -> references('id') -> on('addresses') -> onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
