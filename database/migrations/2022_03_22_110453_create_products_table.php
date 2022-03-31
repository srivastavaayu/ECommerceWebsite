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
            $table -> bigIncrements('id');
            $table -> string('name');
            $table -> mediumText('description');
            $table -> string('sku') -> unique();
            $table -> unsignedBigInteger('category_id') -> nullable();
            $table -> unsignedBigInteger('user_id') -> nullable();
            $table -> bigInteger('price');
            $table -> string('unit');
            $table -> bigInteger('quantity');
            $table -> tinyInteger('is_archived');
            $table -> timestamps();
            $table -> softDeletes();
            $table -> foreign('category_id') -> references('id') -> on('categories') -> onDelete('set null');
            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('set null');
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
