<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotegroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotegroups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 20);
            $table->unsignedBigInteger('cquote_id');
            $table->timestamps();
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
        Schema::dropIfExists('quotegroups');
    }
}
