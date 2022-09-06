<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCclientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cclients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('companyname')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('cclients');
    }
}
