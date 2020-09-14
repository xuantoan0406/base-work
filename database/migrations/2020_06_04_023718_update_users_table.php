<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->string('access_token')->nullable();
            $table->string('industry')->nullable();
            $table->string('work_place')->nullable();
            $table->string('comment')->nullable();
            $table->string('role')->nullable();
            $table->string('avatar')->nullable();
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
            $table->dropColumn('access_token');
            $table->dropColumn('industry');
            $table->dropColumn('work_place');
            $table->dropColumn('comment');
            $table->dropColumn('role');
            $table->dropColumn('avatar');
            $table->string('password');
        });
    }
}
