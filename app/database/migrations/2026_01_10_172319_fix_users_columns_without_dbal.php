<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FixUsersColumnsWithoutDbal extends Migration
{
    public function up()
    {
        // ✅ password が短くて "Data too long" が出る対策（varchar(255) に拡張）
        DB::statement("ALTER TABLE `users` MODIFY `password` VARCHAR(255) NOT NULL");

        // ✅ dob が無くて "Unknown column 'dob'" が出る対策（無ければ追加）
        if (!Schema::hasColumn('users', 'dob')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('dob')->nullable()->after('password');
            });
        }
    }

    public function down()
    {
        // 戻す必要がなければ最低限でOK
        if (Schema::hasColumn('users', 'dob')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('dob');
            });
        }

        // password を戻したいならここに ALTER を書く（任意）
    }
}
