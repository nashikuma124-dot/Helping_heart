<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLineIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // LINEのユーザーID（例: Uxxxxxxxx...）
            $table->string('line_id', 64)->nullable()->unique()->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['line_id']);
            $table->dropColumn('line_id');
        });
    }
}
