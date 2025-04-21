<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->references('id')->on('pages')->onDelete('cascade');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('icon')->default('📄');
            $table->integer('position')->default(0); // For ordering pages
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_template')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            
            // Index for faster lookup
            $table->index(['user_id', 'parent_id', 'is_archived']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};