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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stations_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name_surname');
            $table->string('email')->unique();
            $table->string('contact_number')->nullable();
            $table->string('type');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('position');
            $table->string('password');
            $table->integer('activity_status')->default(1);
            $table->date('ban_start_date')->nullable();
            $table->date('ban_end_date')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
