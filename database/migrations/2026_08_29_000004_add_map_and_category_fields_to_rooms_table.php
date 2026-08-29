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
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('building_name')->constrained('room_categories')->nullOnDelete();
            $table->decimal('map_x', 8, 2)->nullable()->after('is_active');
            $table->decimal('map_y', 8, 2)->nullable()->after('map_x');
            $table->decimal('map_width', 8, 2)->nullable()->after('map_y');
            $table->decimal('map_height', 8, 2)->nullable()->after('map_width');
            $table->foreignId('map_node_id')->nullable()->after('map_height')->constrained('map_nodes')->nullOnDelete();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['map_node_id']);
            $table->dropIndex(['is_active']);
            $table->dropColumn([
                'category_id',
                'map_x',
                'map_y',
                'map_width',
                'map_height',
                'map_node_id',
            ]);
        });
    }
};
