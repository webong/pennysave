<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    
    public function tos()
    {
        return view('legal.tos');
    }
    
    public function privacy()
    {
        return view('legal.privacy');
    }
}
