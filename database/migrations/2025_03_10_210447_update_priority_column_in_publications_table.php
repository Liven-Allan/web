<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePriorityColumnInPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Update the column to enforce only 1, 2, or 3
        Schema::table('publications', function (Blueprint $table) {
            // Change the column type to TINYINT (unsigned) to restrict values to 1, 2, or 3
            $table->tinyInteger('priority')->unsigned()->default(1)->change();
        });

        // Step 2: Update existing data to map old priorities to the new system
        DB::table('publications')->update([
            'priority' => DB::raw('CASE
                WHEN priority <= 3 THEN 1  -- High priority
                WHEN priority <= 6 THEN 2  -- Medium priority
                ELSE 3                     -- Low priority
            END')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes if needed
        Schema::table('publications', function (Blueprint $table) {
            // Change the column back to its original type (e.g., integer)
            $table->integer('priority')->change();
        });
    }
}