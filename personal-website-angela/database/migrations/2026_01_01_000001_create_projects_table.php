<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('role')->nullable();          // mis. "Product Developer / UI-UX Designer"
            $table->string('year')->nullable();           // mis. "2023" atau "2025 - Present"
            $table->enum('type', ['project', 'experience'])->default('project');
            $table->string('summary');                    // ringkasan 1 kalimat untuk kartu di index
            $table->text('description');                  // detail lengkap untuk halaman show
            $table->string('image_path')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
