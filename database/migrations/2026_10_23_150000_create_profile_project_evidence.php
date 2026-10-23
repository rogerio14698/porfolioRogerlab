<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $profiles = DB::table('site_profiles')->get();
        Schema::table('site_profiles', function (Blueprint $table) {
            foreach (range(1, 3) as $area) {
                $table->dropConstrainedForeignId("offer{$area}_project_id");
            }
        });
        Schema::create('profile_project_evidence', function (Blueprint $table) {
            $table->foreignId('site_profile_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('area');
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->primary(['site_profile_id', 'area', 'project_id']);
        });

        foreach ($profiles as $profile) {
            foreach (range(1, 3) as $area) {
                if ($projectId = $profile->{"offer{$area}_project_id"}) {
                    DB::table('profile_project_evidence')->insert([
                        'site_profile_id' => $profile->id, 'area' => $area, 'project_id' => $projectId,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        $selections = DB::table('profile_project_evidence')->orderBy('project_id')->get();
        Schema::dropIfExists('profile_project_evidence');
        Schema::table('site_profiles', function (Blueprint $table) {
            foreach (range(1, 3) as $area) {
                $table->foreignId("offer{$area}_project_id")->nullable()->constrained('projects')->nullOnDelete();
            }
        });
        foreach ($selections as $evidence) {
            $field = "offer{$evidence->area}_project_id";
            DB::table('site_profiles')->where('id', $evidence->site_profile_id)->whereNull($field)
                ->update([$field => $evidence->project_id]);
        }
    }
};
