<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    //
    public function showTerm()
    {
        //
        
        $term = Term::where('type', 'Terms(English)')->first();
        
        return view('auth.terms',compact('term'));
    }

    public function showCondition()
    {
        //
        
        $term = Term::where('type', 'Conditions(English)')->first();
        
        return view('auth.terms',compact('term'));
    }
}
