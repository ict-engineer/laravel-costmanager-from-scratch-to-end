<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteemployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quoteemployees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('hours', 15, 2);
            $table->double('cost', 15, 2);
            $table->double('total', 15, 2);
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('cquote_id');
            $table->timestamps();
            $table->foreign('employee_id')
                ->references('id')->on('employees')
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
        Schema::dropIfExists('quoteemployees');
    }
}
