<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel proposal ide proyek Agentic AI (Tugas P6).
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->string('tema_agent', 50)->default('Ollama');
            $table->text('api_key_secure')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('catatan_review')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
