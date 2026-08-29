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
        Schema::create('map_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('x', 8, 2);
            $table->decimal('y', 8, 2);
            $table->boolean('is_walkable')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_nodes');
    }
};
