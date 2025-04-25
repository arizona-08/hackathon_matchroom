<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY type ENUM(
            'voyageur', 'hotelier', 'admin'
        ) DEFAULT 'voyageur'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY type ENUM(
            'voyageur', 'hotelier'
        ) DEFAULT 'voyageur'");
    }
};
