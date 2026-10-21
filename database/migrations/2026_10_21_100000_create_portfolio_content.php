<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->json('translations');
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_published')->default(false)->index();
            $table->timestamps();
        });
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 160)->unique();
            $table->json('translations');
            $table->text('technologies')->nullable();
            $table->string('repository_url', 2048)->nullable();
            $table->string('website_url', 2048)->nullable();
            $table->string('download_path')->nullable();
            $table->json('media')->nullable();
            $table->unsignedInteger('cover_index')->default(0);
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        $snapshot = json_decode(file_get_contents(database_path('data/portfolio.json')), true, 512, JSON_THROW_ON_ERROR);
        foreach (['skills', 'projects'] as $table) {
            foreach ($snapshot[$table] as $row) {
                foreach (['translations', 'media'] as $field) {
                    if (isset($row[$field])) {
                        $row[$field] = json_encode($row[$field], JSON_THROW_ON_ERROR);
                    }
                }
                if ($table === 'projects') {
                    $row['cover_index'] = count(json_decode($row['media'], true, 512, JSON_THROW_ON_ERROR)) > 1 ? 1 : 0;
                    $row['published_at'] = now();
                }
                DB::table($table)->insert($row + ['is_published' => true, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
    }
};
