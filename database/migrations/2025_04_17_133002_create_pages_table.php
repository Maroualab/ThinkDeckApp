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
            $table->foreignId('workspace_id')->nullable()->constrained('workspaces');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('icon');
            $table->foreignId('parent_page')->nullable()->constrained('pages')->onDelete('cascade');
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_template')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->softDeletes();
            $table->timestamps();
                        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};