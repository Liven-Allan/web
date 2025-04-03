<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectsDetails;

class ProjectsDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectsDetails::create([
            'title' => 'BenchBase',
            'description' => 'Benchmarking is an important, yet often overlooked, aspect of any database management system (DBMS) research and development effort...',
            'image' => null, // Set a path if you have an image
            'people' => 'Andy Pavlo, Wan Shen Lim, Tim Veil (Cockroach Labs), Dana Van Aken, Carlo Curino (MSR), Djellel Eddine Difallah (University of Fribourg), Philippe Cudre-Maroux (University of Fribourg)',
            'acknowledgement' => 'This research was funded (in part) by the National Science Foundation (III-1423210) and the YourKit Java Profiler.',
            'publication' => 'D. Van Aken, D. E. Difallah, A. Pavlo, C. Curino, and P. Cudré-Mauroux, "BenchPress: Dynamic Workload Control in the OLTP-Bench Testbed," in Proceedings of the 2015 ACM SIGMOD International Conference on Management of Data, 2015, pp. 1069-1073.',
            
        ]);
    }
}
