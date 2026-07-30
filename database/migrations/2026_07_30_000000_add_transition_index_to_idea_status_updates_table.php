<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('idea_status_updates', function (Blueprint $table) {
            $table->unique(
                ['idea_id', 'user_id', 'from_status', 'to_status'],
                'idea_status_transition_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('idea_status_updates', function (Blueprint $table) {
            $table->dropUnique('idea_status_transition_unique');
        });
    }
};
