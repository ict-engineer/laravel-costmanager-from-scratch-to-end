<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceNumberToCquotesTable extends Migration
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
            $table->bigInteger('invoice_number')->nullable();
            $table->boolean('isInvoice')->default(false);
            $table->boolean('isQuote')->default(false);
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
            $table->dropColumn('invoice_number');
            $table->dropColumn('isInvoice');
            $table->dropColumn('isQuote');
        });
    }
}
