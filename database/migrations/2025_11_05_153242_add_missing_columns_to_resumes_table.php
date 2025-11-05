<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            if (!Schema::hasColumn('resumes', 'address')) {
                $table->string('address')->nullable();
            }

            if (!Schema::hasColumn('resumes', 'personal_data')) {
                $table->json('personal_data')->nullable();
            }

            if (!Schema::hasColumn('resumes', 'education')) {
                $table->json('education')->nullable();
            }

            if (!Schema::hasColumn('resumes', 'skills')) {
                $table->json('skills')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['address', 'personal_data', 'education', 'skills']);
        });
    }
};
