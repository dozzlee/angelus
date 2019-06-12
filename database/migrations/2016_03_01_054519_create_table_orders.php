<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('orders', function(Blueprint $table)
      {
        $table->increments('id');
        $table->integer('user_id');
        $table->float('total_paid');
        $table->integer('order_progress');
        $table->date('delivered_by');
        $table->string('stripe_transaction_id');
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
      Schema::drop('orders');
    }
}
