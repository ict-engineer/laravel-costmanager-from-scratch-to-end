<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalToCquotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cquotes', function (Blueprint $table) {
            //
            $table->tinyInteger('discount');
            $table->tinyInteger('unprevented');
            $table->tinyInteger('advance');
            $table->double('shopdays', 10, 2);
            $table->double('total', 15, 2);
            $table->string('status', 20)->default('New');
            $table->bigInteger('quote_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cquotes', function (Blueprint $table) {
            //
            $table->dropColumn('discount');
            $table->dropColumn('unprevented');
            $table->dropColumn('shopdays');
            $table->dropColumn('total');
            $table->dropColumn('advance');
            $table->dropColumn('status');
            $table->dropColumn('quote_number');
        });
    }
}
