<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->renameSlug('porfolio', 'portfolio');
    }

    public function down(): void
    {
        // Keep the corrected public URL when rolling back schema changes.
    }

    private function renameSlug(string $from, string $to): void
    {
        if (! DB::table('blogs')->where('link', $from)->exists()) {
            return;
        }

        if (DB::table('blogs')->where('link', $to)->exists()) {
            throw new RuntimeException("Cannot rename blog slug {$from} to {$to}: both slugs already exist.");
        }

        DB::table('blogs')->where('link', $from)->update(['link' => $to]);
    }
};
