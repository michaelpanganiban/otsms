<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->user_type === 0)
            return view('welcome');
        else{
            DB::statement("SET SQL_MODE=''");
        $data = DB::select("SELECT SUM(p.amount) as amount FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE())");
            return view('home', compact('data'));
        }
    }
}
