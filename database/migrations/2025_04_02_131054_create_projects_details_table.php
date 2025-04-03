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
        Schema::create('projects_details', function (Blueprint $table) {
                $table->id(); // Auto-incrementing primary key
                $table->string('title'); // Project title
                $table->text('description')->nullable(); // Project description
                $table->string('image')->nullable(); // Image path
                $table->text('people'); // People involved
                $table->text('acknowledgement')->nullable(); // Acknowledgement
                $table->text('publication')->nullable(); // Publications
                $table->timestamps(); // Adds created_at and updated_at
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_details');
    }
};
