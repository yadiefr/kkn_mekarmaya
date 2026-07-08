<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminEdukasiController extends Controller
{
    /**
     * Display the Kelola Edukasi view.
     */
    public function index()
    {
        // Return a view with a mockup design for managing educational content.
        return view('admin.edukasi');
    }
}
