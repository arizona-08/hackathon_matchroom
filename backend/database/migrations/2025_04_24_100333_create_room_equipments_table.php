<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');

            // Équipements
            $table->boolean('wifi')->default(false);
            $table->boolean('cuisine')->default(false);
            $table->boolean('lave_linge')->default(false);
            $table->boolean('seche_linge')->default(false);
            $table->boolean('climatisation')->default(false);
            $table->boolean('chauffage')->default(false);
            $table->boolean('television')->default(false);
            $table->boolean('fer_a_repasser')->default(false);

            // Petits plus
            $table->boolean('piscine')->default(false);
            $table->boolean('jacuzzi')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('recharge_voiture')->default(false);
            $table->boolean('lit_bebe')->default(false);
            $table->boolean('salle_de_sport')->default(false);
            $table->boolean('bord_de_mer')->default(false);
            $table->boolean('barbecue')->default(false);
            $table->boolean('petit_dejeuner')->default(false);
            $table->boolean('diner')->default(false);
            $table->boolean('cheminee')->default(false);
            $table->boolean('fumeur')->default(false);

            // Accessibilité
            $table->boolean('acces_plain_pied')->default(false);
            $table->boolean('parking_pmr')->default(false);
            $table->boolean('entree_large')->default(false);
            $table->boolean('barre_soutien')->default(false);
            $table->boolean('siege_douche')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('room_equipments');
    }
};
