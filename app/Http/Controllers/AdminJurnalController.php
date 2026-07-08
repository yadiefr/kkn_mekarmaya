<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminJurnalController extends Controller
{
    /**
     * Display the Jurnal & Kas view.
     */
    public function index()
    {
        // For now, we will return a view with a mockup design.
        // Once the database tables for tracking 'Kas Masuk' and 'Kas Keluar' are ready,
        // we can fetch the real data here and pass it to the view.
        return view('admin.jurnal');
    }
}
