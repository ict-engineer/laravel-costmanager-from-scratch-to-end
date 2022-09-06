<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('companyname')->unique();
            $table->string('addline1');
            $table->string('country');
            $table->string('cp');
            $table->string('numberofemployees', 20);
            $table->text('service');
            $table->bigInteger('payment')->nullable();
            $table->date('payment_date')->nullable();
            $table->bigInteger('user_id');
            $table->string('stripe_id')->nullable()->collation('utf8mb4_bin');
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
