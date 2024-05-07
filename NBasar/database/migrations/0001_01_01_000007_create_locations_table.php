<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estate_locations', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255)->nullable();
            $table->string('short_name', 100)->nullable();    
            $table->string('zip_code', 20)->nullable();
            $table->foreignId('county')->constrained('locations_counties');
            $table->text('coordinates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estate_locations');
    }
};
