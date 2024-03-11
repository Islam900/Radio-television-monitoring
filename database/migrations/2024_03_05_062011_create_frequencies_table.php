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
        Schema::create('frequencies', function (Blueprint $table) {
            $table->id();
            $table->double('value');
            $table->foreignId('program_names_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('directions_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('program_languages_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('program_locations_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('polarizations_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequencies');
    }
};
