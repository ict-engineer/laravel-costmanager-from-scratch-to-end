<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmaterials', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('brand')->nullable();
            $table->string('sku')->nullable();
            $table->string('partno')->nullable();
            $table->double('price', 15, 3);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
            $table->foreign('client_id')
                ->references('id')->on('clients')
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
        Schema::dropIfExists('cmaterials');
    }
}
