<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod as ModelsPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethod extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('payment-method');
    }

    public function add(){
        DB::beginTransaction();
        try{
            $data = \request()->all();
            ModelsPaymentMethod::create($data);
            DB::commit();
            return response()->json(['message' => 'Successfully created new payment method.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function edit(){
        DB::beginTransaction();
        try {
            $data = \request()->data;
            $id = \request()->id;
            ModelsPaymentMethod::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the payment method.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            ModelsPaymentMethod::find($id)->delete();
            DB::commit();
            return response()->json(['message' => 'Successfully deleted the payment method.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function viewPaymentMethods(){
        return view('view-payment-methods');
    }
}
