<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixedexpenses', function (Blueprint $table) {
            $table->id();
            // $table->string('expensetype');
            $table->string('name')->unique();
            $table->double('cost', 15, 3);
            $table->string('cycle',10);
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
        Schema::dropIfExists('fixedexpenses');
    }
}
