<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Session;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ip = request()->ip();
        $data = \Location::get($ip);      
        $payments = [];
        if($data)
        {
            if(Session::get('isLanding') != 'yes' && ($data->countryName == 'Mexico' || $data->countryName == 'Spain' || $data->countryName == 'Argentina'))
            {
                Session::put('isLanding', 'yes');
                Session::put('locale', 'es');
                App::setLocale(session()->get('locale'));
            }
            $payments = Payment::where('country', $data->countryName)->get();
        }

        if(!count($payments))
        {
            $payments = Payment::where('country', 'Mexico')->get();
        }

        if(Auth::user())
            return redirect()->route('user.selectType');
        else
            return view('home')->with('payments', $payments);
    }
}
