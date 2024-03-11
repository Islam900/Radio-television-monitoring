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
        Schema::create('edit_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_broadcasts_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('foreign_broadcasts_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('reason');
            $table->integer('solved_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_reasons');
    }
};
