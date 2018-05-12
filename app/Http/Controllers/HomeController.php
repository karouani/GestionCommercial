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
    {      $role=  Auth::user()->role;
       
        return view('Gcommerce',['role' => $role]);
        //return view('Gcommerce');
    }

    public function login()
    {
        
        return view('login');
    }
     
}
