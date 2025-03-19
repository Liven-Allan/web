<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class AllProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all(); // Fetch all projects
        return view('projects', compact('projects')); // Pass projects to the view
    }
}