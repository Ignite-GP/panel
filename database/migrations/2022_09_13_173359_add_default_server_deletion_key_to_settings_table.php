<?php

use Illuminate\Database\Migrations\Migration;

class AddDefaultServerDeletionKeyToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insertOrIgnore(
            array(
                'key' => 'ignite::renewal:deletion',
                'value' => 'true',
            ),
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')
            ->where('key', 'ignite::renewal:deletion')
            ->delete();
    }
}
