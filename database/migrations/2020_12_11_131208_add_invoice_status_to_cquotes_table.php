<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceStatusToCquotesTable extends Migration
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
            $table->string('invoice_status', 20)->default('New');
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
            $table->dropColumn('invoice_status');
        });
    }
}
