<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id');

            $table->smallinteger('allow_indexed_by_google');
            $table->smallinteger('allow_adult_content');
            $table->smallinteger('all_any_person');
            $table->smallinteger('allow_any_person_follow_send_message');
            $table->smallinteger('allow_no_one');

            $table->smallinteger('activity_public_conent');
            $table->smallinteger('activity_comments_and_replies');
            $table->smallinteger('mentions');
            $table->smallinteger('new_messages');
            $table->smallinteger('timed_reminders');
            $table->smallinteger('upvotes');
            $table->smallinteger('new_followers');
            $table->smallinteger('all_stacks_im_following');
            $table->smallinteger('only_my_favorite_stacks');
            $table->smallinteger('stacks_none');
            $table->smallinteger('all_people_im_following');
            $table->smallinteger('only_allowed_direct_message');
            $table->smallinteger('people_none');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
