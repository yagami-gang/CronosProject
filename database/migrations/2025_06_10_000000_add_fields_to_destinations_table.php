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
        Schema::table('destinations', function (Blueprint $table) {
            // Ajout du champ populaire qui a été supprimé dans une migration précédente
            $table->boolean('populaire')->default(false)->after('statut');
            
            // Ajout des champs pour les informations affichées dans la carte
            $table->string('duree_sejour')->nullable()->after('populaire');
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
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn([
                'populaire',
                'duree_sejour',
                'date_depart',
                'prix_a_partir_de',
                'note'
            ]);
        });
    }
};