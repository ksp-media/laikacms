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
            $table->integer('position')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laikacms_assets_folder', function (Blueprint $table) {
            //
        });
    }
}
