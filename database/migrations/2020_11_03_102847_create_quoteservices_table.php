<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quoteservices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider');
            $table->double('cost', 15, 2);
            $table->double('utility', 4, 2);
            $table->double('price', 15, 2);
            $table->unsignedBigInteger('cservice_id');
            $table->unsignedBigInteger('cquote_id');
            $table->timestamps();
            $table->foreign('cservice_id')
                ->references('id')->on('cservices')
                ->onDelete('cascade');
            $table->foreign('cquote_id')
                ->references('id')->on('cquotes')
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
        Schema::dropIfExists('quoteservices');
    }
}
