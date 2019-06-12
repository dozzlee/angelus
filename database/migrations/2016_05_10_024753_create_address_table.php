<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
      Schema::create('addresses', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('order_id');
          $table->string('country');
          $table->string('state');
          $table->string('zip_code');
          $table->string('phone_number');
          $table->string('address_line_1');
          $table->string('address_line_2');
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
      Schema::create('addresses', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('order_id');
          $table->string('country');
          $table->string('state');
          $table->string('zip_code');
          $table->string('phone_number');
          $table->string('address_line_1');
          $table->string('address_line_2');
          $table->timestamps();
      });
    }
}
