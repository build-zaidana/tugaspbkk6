<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Indeks untuk kolom yang dipakai pencarian & filter di panel admin.
     * nrp dan nip sudah memiliki indeks unique.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('department');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index('judul');
            $table->index('tema_agent');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['judul']);
            $table->dropIndex(['tema_agent']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['department']);
        });
    }
};
