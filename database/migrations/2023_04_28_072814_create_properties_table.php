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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('district');
            $table->integer('width');
            $table->integer('length');
            $table->string('category');
            $table->string('kind');
            $table->string('images');
            $table->integer('livingrooms');
            $table->integer('bedrooms');
            $table->integer('area');
            $table->integer('bathrooms');
            $table->integer('age');
            $table->integer('kitchen');
            $table->integer('ac');
            $table->integer('furnished');
            $table->integer('rentperiod');
            $table->integer('price');
            $table->string('other');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
