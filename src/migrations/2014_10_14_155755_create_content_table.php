<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('laikacms_content')) {
                    return;
                }
                Schema::create('laikacms_content', function($table)
                {
                    $table->increments('id');
                    $table->string('key', 250);
                    $table->text('value');
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
