<?php

namespace App\Http\Controllers;

use App\Models\Artikel;

class EdukasiController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->take(3)->get();

        return view('edukasi', compact('artikels'));
    }
}