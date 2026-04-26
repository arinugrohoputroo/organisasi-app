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
        Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('session');
    $table->date('date')->nullable();
    $table->string('status'); // hadir / kosong
    $table->foreignId('recorded_by')->nullable()->constrained('users');
    $table->timestamps();
});

        Schema::create('attendance_sessions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
