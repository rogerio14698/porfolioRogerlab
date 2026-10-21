<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carousel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mode', 20)->default('automatic');
            $table->boolean('autoplay')->default(true);
            $table->unsignedSmallInteger('interval_seconds')->default(8);
            $table->boolean('pause_on_hover')->default(true);
            $table->boolean('show_indicators')->default(true);
            $table->unsignedSmallInteger('max_slides')->default(0);
            $table->timestamps();
        });
        Schema::create('carousel_slides', function (Blueprint $table) {
            $table->id();
            $table->string('item_type', 20);
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->unique(['item_type', 'item_id']);
            $table->index(['is_visible', 'position']);
        });
        DB::table('carousel_settings')->insert(['created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        Schema::dropIfExists('carousel_slides');
        Schema::dropIfExists('carousel_settings');
    }
};
