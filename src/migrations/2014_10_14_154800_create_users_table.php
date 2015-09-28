<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('laikacms_user')) {
                    return;
                }
                Schema::create('laikacms_user', function($table)
                {
                    $table->increments('id');
                    $table->string('email', 250);
                    $table->string('password', 250);
                    $table->dateTime('created_at');
                    $table->dateTime('updated_at');
                    
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
