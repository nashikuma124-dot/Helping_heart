<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class WidenEmailInUsersTable extends Migration
{
    public function up()
    {
        // email を 255 に拡張
        DB::statement("ALTER TABLE `users` MODIFY `email` VARCHAR(255) NOT NULL");
    }

    public function down()
    {
        // 元に戻す（必要なら。元が何文字かわからないなら消してもOK）
        DB::statement("ALTER TABLE `users` MODIFY `email` VARCHAR(100) NOT NULL");
    }
}
