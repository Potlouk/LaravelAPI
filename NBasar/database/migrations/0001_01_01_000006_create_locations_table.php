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
        Schema::create('estate_locations', function (Blueprint $table) {
            $table->id();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();    
            $table->string('zip_code', 20)->nullable();
            $table->text('cordinates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_locations');
    }
};
