<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('Gcommerce');
    }

    public function log()
    {
        return view('login');
    }
  /*  public function logout(){
        Auth::logout();
        Session::flush();
    
        return redirect('/login');
      }
    */
}
