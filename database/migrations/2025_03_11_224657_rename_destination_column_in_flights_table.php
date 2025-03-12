<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameDestinationColumnInFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            // Vérifier si la colonne destination existe
            if (Schema::hasColumn('flights', 'destination')) {
                // Au lieu d'utiliser renameColumn, utiliser une requête SQL directe
                    DB::statement('ALTER TABLE flights CHANGE destination destination_id BIGINT(20)');
                
                // Décommenter ces lignes si vous voulez ajouter la clé étrangère
                $table->unsignedBigInteger('destination_id')->change();
                $table->foreign('destination_id')
                ->references('id')
                 ->on('destinations')
                 ->onDelete('cascade');
                // Update flight status enum values
                DB::statement("ALTER TABLE flights MODIFY COLUMN status ENUM('planifié', 'confirmé', 'annulé')");
                // Drop the status column
                $table->dropColumn('statut');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère si elle existe
            if (Schema::hasColumn('flights', 'destination_id')) {
                $table->dropForeign(['destination_id']);
                
                // Utiliser une requête SQL directe pour renommer la colonne
                DB::statement('ALTER TABLE flights CHANGE destination_id destination VARCHAR(255)');
                
                // Restore original status enum values if needed
                DB::statement("ALTER TABLE flights MODIFY COLUMN status ENUM('planifié', 'confirmé', 'annulé')");
            }
        });
    }
}