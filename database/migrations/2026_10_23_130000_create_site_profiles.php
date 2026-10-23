<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_profiles', function (Blueprint $table) {
            $table->id();
            $table->json('translations');
            $table->boolean('research_enabled')->default(true);
            $table->string('research_route', 30)->default('about');
            $table->boolean('photo_enabled')->default(true);
            $table->boolean('photo_is_default')->default(true);
            $table->string('photo_path')->nullable();
            foreach (range(1, 3) as $index) {
                $table->foreignId("offer{$index}_project_id")->nullable()->constrained('projects')->nullOnDelete();
            }
            $table->timestamps();
        });

        $translations = [];
        foreach (['es', 'en', 'pt'] as $locale) {
            $copy = require lang_path("$locale/profile.php");
            $translations[$locale] = $copy['defaults'];
        }
        DB::table('site_profiles')->insert([
            'id' => 1,
            'translations' => json_encode($translations, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
            'offer1_project_id' => DB::table('projects')->where('slug', 'gestor-contenido')->value('id'),
            'offer2_project_id' => DB::table('projects')->where('slug', 'portfolio')->value('id'),
            'offer3_project_id' => DB::table('projects')->where('slug', 'n8n-linkedin')->value('id'),
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_profiles');
    }
};
