<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE negotiations MODIFY status ENUM(
            'proposed', 'accepted', 'refused', 'countered', 'pending'
        ) DEFAULT 'proposed'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE negotiations MODIFY status ENUM(
            'proposed', 'accepted', 'refused', 'countered'
        ) DEFAULT 'proposed'");
    }
};