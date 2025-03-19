<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DescriptionText; 

class GuestController extends Controller
{


public function showDescription()
{
    // Assuming you have a Description model for the 'description' table
      $descriptionText = DescriptionText::latest()->first(); // Get the most recent hero text
    // Or if you want to fetch by specific criteria, you can adjust the query
    // $descriptionText = \App\Models\Description::where('some_column', 'value')->first();
    //dd($descriptionText->getTable());  // This will display the table name being used by the model


    return view('frontend.master', compact('descriptionText')); // Pass the variable to the view
}

}