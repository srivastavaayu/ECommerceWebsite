<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEComWebStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_com_web_stats', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('product_id') -> nullable();
            $table -> unsignedBigInteger('unit_sold') -> nullable();
            $table -> timestamps();
            $table -> foreign('product_id') -> references('id') -> on('products') -> onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_com_web_stats');
    }
}
