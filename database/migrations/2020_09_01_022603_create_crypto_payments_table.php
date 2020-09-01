<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crypto_payments', function(Blueprint $table)
		{
			$table->increments('paymentID');
			$table->integer('boxID')->unsigned()->default(0)->index('boxID');
			$table->enum('boxType', array('paymentbox','captchabox'))->index('boxType');
			$table->string('orderID', 50)->default('')->index('orderID');
			$table->string('userID', 50)->default('')->index('userID');
			$table->string('countryID', 3)->default('')->index('countryID');
			$table->string('coinLabel', 6)->default('')->index('coinLabel');
			$table->float('amount', 20, 8)->default(0.00000000)->index('amount');
			$table->float('amountUSD', 20, 8)->default(0.00000000)->index('amountUSD');
			$table->boolean('unrecognised')->default(0)->index('unrecognised');
			$table->string('addr', 34)->default('')->index('addr');
			$table->char('txID', 64)->default('')->index('txID');
			$table->dateTime('txDate')->nullable()->index('txDate');
			$table->boolean('txConfirmed')->default(0)->index('txConfirmed');
			$table->dateTime('txCheckDate')->nullable()->index('txCheckDate');
			$table->boolean('processed')->default(0)->index('processed');
			$table->dateTime('processedDate')->nullable()->index('processedDate');
			$table->dateTime('recordCreated')->nullable()->index('recordCreated');
			$table->index(['boxID','orderID','userID'], 'key2');
			$table->index(['boxID','orderID'], 'key1');
			$table->unique(['boxID','orderID','userID','txID','amount','addr'], 'key3');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('crypto_payments');
	}

}
