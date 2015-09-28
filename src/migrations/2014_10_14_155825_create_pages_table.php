<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
                if (Schema::hasTable('laikacms_page')) {
                    return;
                }
                Schema::create('laikacms_page', function($table)
                {
                    $table->increments('id');
                    $table->string('title', 250);
                    $table->text('slug');
                    $table->text('template');
                    $table->text('content');
                    $table->string('meta_title', 250);
                    $table->string('meta_tags', 250);
                    $table->text('meta_description');
                    $table->dateTime('created_at');
                    $table->dateTime('updated_at');
                    $table->text('compiled_template');
                    
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
