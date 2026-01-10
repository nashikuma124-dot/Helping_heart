<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameDateofbirthToDobInUsersTable extends Migration
{
    public function up()
    {
        $hasDob = Schema::hasColumn('users', 'dob');
        $hasDateofbirth = Schema::hasColumn('users', 'dateofbirth');

        // すでに dob がある場合：dateofbirth が残ってたら移して削除
        if ($hasDob && $hasDateofbirth) {
            DB::statement("UPDATE `users` SET `dob` = `dateofbirth` WHERE `dob` IS NULL AND `dateofbirth` IS NOT NULL");
            DB::statement("ALTER TABLE `users` DROP COLUMN `dateofbirth`");
            return;
        }

        // dob がなくて dateofbirth がある場合：リネーム
        if (!$hasDob && $hasDateofbirth) {
            DB::statement("ALTER TABLE `users` CHANGE `dateofbirth` `dob` DATE NOT NULL");
            return;
        }

        // どちらも無い/既に整ってる → 何もしない
    }

    public function down()
    {
        $hasDob = Schema::hasColumn('users', 'dob');
        $hasDateofbirth = Schema::hasColumn('users', 'dateofbirth');

        // rollback 時：dateofbirth が無くて dob があるなら戻す
        if ($hasDob && !$hasDateofbirth) {
            DB::statement("ALTER TABLE `users` CHANGE `dob` `dateofbirth` DATE NOT NULL");
        }
    }
}
