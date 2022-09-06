<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotematerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotematerials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('material_id');
            $table->boolean('isMine');
            $table->bigInteger('quantity');
            $table->unsignedBigInteger('quote_item_id');
            $table->string('description');
            $table->double('price', 15, 2);
            $table->string('provider');
            $table->timestamps();
            $table->foreign('quote_item_id')
                ->references('id')->on('quoteitems')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotematerials');
    }
}
