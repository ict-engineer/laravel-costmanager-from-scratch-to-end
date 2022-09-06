<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quoteitems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('quantity');
            $table->double('cost', 15, 2);
            $table->double('utility', 4, 2);
            $table->double('total', 15, 2);
            $table->unsignedBigInteger('quote_group_id');
            $table->timestamps();
            $table->foreign('quote_group_id')
                ->references('id')->on('quotegroups')
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
        Schema::dropIfExists('quoteitems');
    }
}
