<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pages', function (Blueprint $table) {
        $table->foreignId('workspace_id')->nullable()->constrained()->nullOnDelete();
    });
}

public function down()
{
    Schema::table('pages', function (Blueprint $table) {
        $table->dropForeign(['workspace_id']);
        $table->dropColumn('workspace_id');
    });
}

  
};
