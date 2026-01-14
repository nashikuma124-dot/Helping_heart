<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_properties_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');

            // ✅ 後続のalterで参照されるので必須
            $table->string('address')->nullable();

            // ✅ すでに後続migrationで追加しようとしてるが、
            // 既に "Yes" 扱いの可能性もあるので最初から持たせておく
            $table->string('nearest_station', 50)->nullable();
            $table->unsignedTinyInteger('walk_minutes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
