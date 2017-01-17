<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->user_type_id == 1)
        {
            return redirect('/account');
        }
        elseif(Auth::user()->user_type_id == 2)
        {
            if (Auth::user()->staff->staff_type_id == 1)
            {
                return redirect('/dentist');
            }
            else if (Auth::user()->staff->staff_type_id == 5)
            {
                return redirect('/cashier');
            }
            else if (Auth::user()->staff->staff_type_id == 2)
            {
                return redirect('/doctor');
        }
        else if (Auth::user()->staff->staff_type_id == 3)
        {
          return redirect('/lab');
        }
        else if (Auth::user()->staff->staff_type_id == 4)
        {
          return redirect('/xray');
        }
        else if (Auth::user()->staff->staff_type_id == 5)
        {
          return redirect('/cashier');
        }
            
        }
        else if (Auth::user()->user_type_id == 3)
        {
          return redirect ('/admin');
        }
        else
        {
            return redirect('/');
        }
    }
}
