<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('onlyFollowingsTasks', 'only_followings_tasks');
            $table->renameColumn('checkState', 'check_state');
            $table->renameColumn('isStaff', 'is_staff');
            $table->renameColumn('isDeveloper', 'is_contributor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('only_followings_tasks', 'onlyFollowingsTasks');
            $table->renameColumn('check_state', 'checkState');
            $table->renameColumn('is_staff', 'isStaff');
            $table->renameColumn('is_contributor', 'isDeveloper');
        });
    }
}
