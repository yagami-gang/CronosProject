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
        Schema::table('flights', function (Blueprint $table) {
            // Ajout des champs pour les informations affichées dans la carte
            $table->string('duree_sejour')->nullable()->after('status');
            $table->date('date_depart')->nullable()->after('duree_sejour');
            $table->decimal('prix_a_partir_de', 10, 2)->nullable()->after('date_depart');
            $table->decimal('note', 3, 1)->nullable()->after('prix_a_partir_de');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn([
                'duree_sejour',
                'date_depart',
                'prix_a_partir_de',
                'note'
            ]);
        });
    }
};