<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number')->unique();
            $table->string('departure');
            $table->string('destination');
            $table->datetime('departure_time');
            $table->datetime('arrival_time');
            $table->decimal('price', 10, 2);
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->enum('status', ['active', 'cancelled', 'completed'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
