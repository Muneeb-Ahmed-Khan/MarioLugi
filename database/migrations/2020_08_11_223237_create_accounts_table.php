<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('username',100);
            $table->string('password',100);
            $table->string('ip_address',100);
            $table->string('location',100);
            $table->string('browser',40);
            $table->string('screen',40);
            $table->string('user_agent',500);
            $table->string('time',100);

            $table->string('record_type',10);
            $table->integer('price');
            
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
        Schema::dropIfExists('accounts');
    }
}
