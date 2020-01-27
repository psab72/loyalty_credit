<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLendingSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lending_summary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('amount', 8, 2);
            $table->float('repaid_amount', 8, 2);
            $table->float('revenue', 8, 2);
            $table->integer('total_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lending_summary');
    }
}
