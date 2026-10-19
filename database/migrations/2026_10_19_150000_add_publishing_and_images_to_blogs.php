<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('translations')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
        });

        foreach (DB::table('blogs')->orderBy('id')->get() as $blog) {
            DB::table('blogs')->where('id', $blog->id)->update([
                'link' => $blog->link ?: (Str::slug($blog->title) ?: 'articulo').'-'.$blog->id,
                'is_published' => true,
                'published_at' => $blog->created_at ?? now(),
            ]);
        }

        Schema::table('blogs', function (Blueprint $table) {
            $table->unique('link');
        });

        Schema::create('blog_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->json('alt');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_images');
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropUnique(['link']);
            $table->dropIndex(['is_published']);
            $table->dropColumn(['translations', 'is_published', 'published_at']);
        });
    }
};
