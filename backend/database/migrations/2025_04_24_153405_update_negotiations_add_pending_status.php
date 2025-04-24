<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE negotiations MODIFY status ENUM(
            'pending', 'proposed', 'countered', 'accepted', 'refused', 'expired', 'cancelled'
        ) DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE negotiations MODIFY status ENUM(
            'proposed', 'accepted', 'refused', 'countered'
        ) DEFAULT 'proposed'");
    }
};
