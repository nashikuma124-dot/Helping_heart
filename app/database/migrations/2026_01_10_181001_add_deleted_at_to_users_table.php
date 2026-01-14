<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 既にある場合でもエラーにならない保険
            if (!Schema::hasColumn('users', 'deleted_at')) {
                // Laravel標準のSoftDeletes
                $table->softDeletes(); // deleted_at (nullable timestamp) を追加
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'deleted_at')) {
                // Laravel標準のSoftDeletes削除
                $table->dropSoftDeletes();
            }
        });
    }
}
