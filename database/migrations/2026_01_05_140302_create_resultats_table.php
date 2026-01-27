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
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('etudiant_id')->constrained();
            $table->foreignId('annee_id')->constrained();

            $table->enum('statut', ['admis', 'rattrapage', 'refuse']);

            $table->boolean('valide')->default(false);
            $table->boolean('publie')->default(false);

            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultats');
    }
};
