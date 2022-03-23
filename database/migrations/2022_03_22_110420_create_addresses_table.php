<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('user_id');
            $table -> string('address_line_1');
            $table -> string('address_line_2');
            $table -> string('city');
            $table -> string('state');
            $table -> string('country');
            $table -> string('pin_code', 6);
            $table -> timestamps();
            $table -> softDeletes();
            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
