<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            // Ajouter la nouvelle colonne
            $table->unsignedBigInteger('ville_depart_id')->nullable()->after('flight_number');
            $table->foreign('ville_depart_id')->references('id')->on('destinations');
            
            // Supprimer l'ancienne colonne
            $table->dropColumn('departure');
        });
    }

    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            // Recréer l'ancienne colonne
            $table->string('departure')->nullable()->after('flight_number');
            
            // Supprimer la nouvelle colonne
            $table->dropForeign(['ville_depart_id']);
            $table->dropColumn('ville_depart_id');
        });
    }
};