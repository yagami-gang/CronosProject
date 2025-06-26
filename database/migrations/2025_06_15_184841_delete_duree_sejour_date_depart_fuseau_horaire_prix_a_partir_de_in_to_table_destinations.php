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
            $table->dropColumn('duree_sejour');
            $table->dropColumn('date_depart');
            $table->dropColumn('code_aeroport');
            $table->dropColumn('prix_a_partir_de');
            $table->dropColumn('fuseau_horaire');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('duree_sejour')->nullable();
            $table->date('date_depart')->nullable();
            $table->decimal('prix_a_partir_de', 10, 2)->nullable();
            $table->string('fuseau_horaire')->nullable();
            $table->string('code_aeroport')->nullable();
        });
    }
};
