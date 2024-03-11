<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('foreign_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->foreignId('stations_id')->constrained('stations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('report_date')->default(\Carbon\Carbon::now());
            $table->foreignId('frequencies_id')->constrained('frequencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('program_names_id')->constrained('program_names')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('directions_id')->constrained('directions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('program_languages_id')->constrained('program_languages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('program_locations_id')->nullable()->constrained('program_locations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('emfs_level_in');
            $table->float('emfs_level_out')->nullable();
            $table->integer('response_direction_in');
            $table->integer('response_direction_out')->nullable();
            $table->string('polarization');
            $table->string('response_quality');
            $table->string('sending_from')->nullable();
            $table->text('note')->nullable();
            $table->string('device');
            $table->integer('accepted_status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foreign_broadcasts');
    }
};
