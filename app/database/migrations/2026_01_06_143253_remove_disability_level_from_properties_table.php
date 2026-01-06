<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDisabilityLevelFromPropertiesTable extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            // disability_level が存在する場合のみ削除
            if (Schema::hasColumn('properties', 'disability_level')) {
                $table->dropColumn('disability_level');
            }
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            // ロールバック用（元に戻す）
            $table->unsignedBigInteger('disability_level')->nullable();
        });
    }
}
