<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_workspaces', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('workspace_id')->constrained('workspaces');
            $table->enum('is_allowed',['pending','allowed','rejected'])->default('pending');

    });
 
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
