<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->integer('floor');
            $table->integer('reported_count')->default(0);
            $table->uuid('uuid');
            $table->foreignId('type')->constrained('estate_types');
            $table->foreignId('location')->constrained('estate_locations');
            $table->foreignId('ownership_type')->constrained('estate_ownership_types');
            $table->foreignId('energy_consumption')->constrained('estate_energy_consumptions');
            $table->foreignId('sub_type')->constrained('estate_sub_types');
            $table->foreignId('building_material')->constrained('estate_building_material_types');
            $table->foreignId('condition')->constrained('estate_conditions_types');
            $table->foreignId('room_type')->nullable()->default(null)->constrained('estate_room_types');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('area');
            $table->boolean('transaction_type');
            $table->boolean('furniture')->nullable();
            $table->json('images');
            $table->text('info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
