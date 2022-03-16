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
        DB::statement("SET SQL_MODE=''");
        $data = DB::select("SELECT p.*, COUNT(o.order_id) as ordered_count FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id WHERE p.status = 'Active' AND o.status NOT IN ('Pending', 'Disapproved') GROUP BY p.product_id");  
        $custom = DB::select("SELECT (SUM(p.downpayment) + SUM(p.fullpayment)) as amount FROM customization p WHERE p.status NOT IN('Pending', 'Disapproved') AND MONTH(p.created_at) = MONTH(CURRENT_DATE())");
        
        if(Auth::user()->user_type === 0)
            return view('welcome', compact('data'));
        else{
            return view('home', compact('data', 'custom'));
        }
    }
}
