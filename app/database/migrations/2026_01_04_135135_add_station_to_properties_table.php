<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStationToPropertiesTable extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('nearest_station', 50)->nullable()->after('address');
            $table->unsignedTinyInteger('walk_minutes')->nullable()->after('nearest_station');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['nearest_station', 'walk_minutes']);
        });
    }
}
