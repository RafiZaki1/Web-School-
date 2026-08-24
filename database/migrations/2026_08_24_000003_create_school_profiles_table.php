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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('school_logo')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_position')->nullable();
            $table->string('principal_photo')->nullable();
            $table->text('welcome_message')->nullable();
            $table->string('background_image')->nullable();
            $table->integer('established_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
