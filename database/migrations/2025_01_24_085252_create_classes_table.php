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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Class Name (e.g., "Class 1", "Class 2")
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade'); // Teacher who owns the class
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null'); // Assigning students to a class
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class_id');
        });
    }
};
