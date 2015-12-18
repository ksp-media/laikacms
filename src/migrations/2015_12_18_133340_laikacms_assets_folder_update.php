<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LCMSAssetsFolderUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('laikacms_assets_folder', 'position')) {
            return;
        }
        
        Schema::table('laikacms_assets_folder', function (Blueprint $table) {
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
        Schema::table('laikacms_page', function (Blueprint $table) {
            //
        });
    }
}
