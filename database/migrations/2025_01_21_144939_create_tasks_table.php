<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('title'); // Title of the task
            $table->text('description')->nullable(); // Description, optional
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade'); // Participant (research assistant)
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade'); // Creator of the task
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Priority level
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending'); // Task status
            $table->date('due_date'); // Due date for the task
            $table->timestamps(); // Created_at and Updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
