<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesArticles', function(Blueprint $table){
            $table->increments('id');
            $table->integer('sale_id');
            $table->integer('product_id');
            $table->double('price',16,2);
            $table->integer('quantity');
            $table->integer('sucursal_id')->nullable();
            $table->nullabletimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salesArticles');
    }
}
