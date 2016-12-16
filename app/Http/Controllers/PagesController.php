<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
	public function index()
    {
    	$params['navbar_active'] = 'home';
        return view('index', $params);
    }
	public function scheduleappointment()
    {
    	$params['navbar_active'] = 'scheduleappointment';
        return view('scheduleappointment', $params);
    }
}
