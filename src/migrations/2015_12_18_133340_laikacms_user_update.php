<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LCMSUserUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('laikacms_user', 'user_role_id')) {
            return;
        }
        
   
        
         Schema::table('laikacms_user', function (Blueprint $table) {
              $table->renameColumn('jbkcms_user_role_id', 'user_role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laikacms_user', function (Blueprint $table) {
            //
        });
    }
}
