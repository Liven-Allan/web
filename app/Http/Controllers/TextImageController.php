<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TextImageController extends Controller
{
    public function generateSvg($id)
    {
        // Fetch phrase from the database
        $word = Word::find($id);

        if (!$word) {
            abort(404);
        }

        // Extract initials (e.g., "Post Me UP" → "PMU")
        $initials = strtoupper(implode('', array_map(fn($w) => $w[0], explode(' ', $word->phrase))));

        // Define SVG content
        $svg = <<<SVG
        <svg width="150" height="150" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
            <rect width="150" height="150" rx="20" fill="#d00"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="50" fill="white" text-anchor="middle" alignment-baseline="central" font-weight="bold">$initials</text>
        </svg>
        SVG;

        return Response::make($svg, 200)->header('Content-Type', 'image/svg+xml');
    }
}
