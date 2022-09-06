<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cservices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->double('cost', 15, 3);
            $table->integer('utility');
            $table->double('price', 15, 3);
            $table->bigInteger('client_id');
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
        Schema::dropIfExists('cservices');
    }
}
