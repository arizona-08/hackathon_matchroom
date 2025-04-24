<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('search_presets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('city')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->float('min_price')->nullable();
            $table->float('max_price')->nullable();

            $table->integer('capacity')->nullable();
            $table->integer('beds')->nullable();
            $table->float('stars_min')->nullable();

            $table->json('equipment_filters')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_presets');
    }
};
