<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangePasswordLengthInUsersTable extends Migration
{
    public function up()
    {
        // ✅ doctrine/dbal不要：SQLで直接カラム変更
        DB::statement("ALTER TABLE `users` MODIFY `password` VARCHAR(255) NOT NULL");
    }

    public function down()
    {
        // 必要なら戻す（元がVARCHAR(60)想定）
        DB::statement("ALTER TABLE `users` MODIFY `password` VARCHAR(60) NOT NULL");
    }
}
