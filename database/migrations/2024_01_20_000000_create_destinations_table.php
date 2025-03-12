<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('pays');
            $table->string('ville');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('fuseau_horaire')->default('UTC');
            $table->boolean('populaire')->default(false);
            $table->boolean('en_vedette')->default(false);
            $table->timestamps();

            $table->index(['populaire', 'en_vedette']);
            $table->index(['pays', 'ville']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('destinations');
    }
};