<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCreditRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->integer('requestee_id')->nullable();
            $table->integer('requester_id')->nullable();
            $table->float('amount', 8, 2)->nullable();
            $table->enum('status', ['processing', 'accepted', 'denied'])->nullable();
            $table->integer('payment_term_id')->nullable();
            $table->dateTime('date_requested')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
