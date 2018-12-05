<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsAddStacksPeopleFollowingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            
            $table->dropColumn('all_stacks_im_following','only_my_favorite_stacks', 'stacks_none', 'all_people_im_following', 'only_allowed_direct_message', 'people_none');

            $table->smallinteger('stacks_following');
            $table->smallinteger('people_following');

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
