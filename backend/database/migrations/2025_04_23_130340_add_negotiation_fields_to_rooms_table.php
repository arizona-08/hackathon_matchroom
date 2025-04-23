<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('negotiation_max_discount')->default(30); // % au-delà duquel on refuse automatiquement
            $table->integer('negotiation_auto_accept_threshold')->default(10); // % en-dessous duquel on accepte automatiquement
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['negotiation_max_discount', 'negotiation_auto_accept_threshold']);
        });
    }

};
