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
        // $temp = new Order();
        // $data = $temp->product_sale()->sum('amount');
        // dd($data);
        return view('home');
    }
}
