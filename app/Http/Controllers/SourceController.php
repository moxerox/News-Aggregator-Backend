<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Retrieve all sources from the database
        $sources = Source::all();

        // Return a JSON response with the sources
        return response()->json(['sources' => $sources]);
    }

}
