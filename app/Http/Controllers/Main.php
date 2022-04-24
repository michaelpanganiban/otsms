<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $data = DB::select("SELECT SUM(p.amount) as amount FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id WHERE MONTH(o.created_at) IS NOT NULL AND MONTH(o.created_at) = MONTH(CURRENT_DATE()) AND o.status NOT IN('Pending', 'Disapproved')");
        $custom = DB::select("SELECT (SUM(p.downpayment) + SUM(p.fullpayment)) as amount FROM customization p WHERE p.status NOT IN('Pending', 'Disapproved') AND MONTH(p.created_at) IS NOT NULL AND MONTH(p.created_at) = MONTH(CURRENT_DATE())");
        // print_r($data);
        // print_r($custom);
        return view('home', compact('custom', 'data'));
    }

    public function fetchDashboard(){
        $year = request()->year;
        if($year == Date('Y')){
            $year2 = "(YEAR(CURRENT_DATE()))";
        }
        else{
            $year2 = $year;
        }
        //sales per month this year
        $this_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = $year2 AND o.status NOT IN('Pending', 'Disapproved') GROUP BY MONTH(o.created_at)");
        //last year
        $last_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = ($year2-1) GROUP BY MONTH(o.created_at)");

        //custom per month this year
        $this_year_custom = DB::select("SELECT SUM(p.price) as price, MONTH(p.created_at) as month_date FROM customization p WHERE MONTH(p.created_at) IS NOT NULL and YEAR(p.created_at) = $year2 AND p.status NOT IN('Pending', 'Disapproved')GROUP BY MONTH(p.created_at)");
        //last year
        $last_year_custom = DB::select("SELECT SUM(p.price) as price, MONTH(p.created_at) as month_date FROM customization p WHERE MONTH(p.created_at) IS NOT NULL and YEAR(p.created_at) = ($year - 1) AND p.status NOT IN('Pending', 'Disapproved')GROUP BY MONTH(p.created_at)");
        
        $type = DB::SELECT("SELECT COUNT(o.order_id) as order_count, p.type FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = $year2 GROUP BY p.type");
        $custom = DB::SELECT("SELECT COUNT(custom_id) as custom_count FROM customization WHERE status <> 'Pending' AND YEAR(created_at) = $year2 ");

        $data_order = DB::select("SELECT SUM(p.amount) as amount FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id WHERE MONTH(o.created_at) IS NOT NULL AND MONTH(o.created_at) = MONTH(CURRENT_DATE()) AND o.status NOT IN('Pending', 'Disapproved')");

        $data_custom = DB::select("SELECT SUM(p.price) as amount FROM customization p WHERE p.status NOT IN('Pending', 'Disapproved') AND MONTH(p.created_at) IS NOT NULL AND MONTH(p.created_at) = MONTH(CURRENT_DATE())");
       
        return response()->json(['this_year' => $this_year, 'last_year' => $last_year, 'type' => $type, 'custom' => $custom, 'last_year_custom' => $last_year_custom, 'this_year_custom' => $this_year_custom, 'data_order'=>$data_order, 'data_custom' => $data_custom]);
    }
}
