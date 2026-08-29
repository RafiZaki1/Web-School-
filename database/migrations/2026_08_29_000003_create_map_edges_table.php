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
        Schema::create('map_edges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_node_id')->constrained('map_nodes')->cascadeOnDelete();
            $table->foreignId('to_node_id')->constrained('map_nodes')->cascadeOnDelete();
            $table->decimal('distance', 8, 2);
            $table->boolean('is_walkable')->default(true)->index();
            $table->timestamps();

            $table->index(['from_node_id', 'to_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_edges');
    }
};
