<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('quote_id');
            $table->boolean('showMaterial');
            $table->boolean('showService');
            $table->boolean('showEmployee');
            $table->boolean('showOnlyTotal');
            $table->longText('content');
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
        Schema::dropIfExists('public_quotes');
    }
}
