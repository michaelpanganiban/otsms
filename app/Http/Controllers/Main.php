<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Main extends Controller
{
    public function updateProfile(){
        DB::beginTransaction();
        try {
            $data = \request()->data;
            $id = \request()->id;
            User::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated your profile.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function changePassword(){
        DB::beginTransaction();
        try {
            $data = ["password" => Hash::make(request()->new_password)];
            $id = request()->id;
            User::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated your password.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
    
    public function about(){
        return view('about');
    }

    public function dashboard(){
        DB::statement("SET SQL_MODE=''");
        $data = DB::select("SELECT SUM(p.amount) as amount FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE())");
        
        return view('home', compact('data'));
    }

    public function fetchDashboard(){
        //sales per month this year
        $this_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = YEAR(CURRENT_DATE()) GROUP BY MONTH(o.created_at)");
        $last_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = (YEAR(CURRENT_DATE()) -1) GROUP BY MONTH(o.created_at)");
        
        return response()->json(['this_year' => $this_year, 'last_year' => $last_year]);
    }
}
