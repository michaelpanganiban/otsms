<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Orders extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->user_type === 0)
            $data = Order::with(
                ['product_sale'=> function($product_sale){$product_sale->select('*');}],
                ['user'=> function($users){$users->select('*');}]
            )->where('user_id', Auth::id())->get();
        else
            $data = Order::with(
                ['product_sale'=> function($product_sale){$product_sale->select('*');}],
                ['user'=> function($users){$users->select('*');}]
            )->get();
        return view('orders', compact('data'));
    }

    public function add(){
        DB::beginTransaction();
        try{
            $data = \request()->data;
            $data += ['reference_id' => 'ITM-'.Date('Ymdsss')];
            $data += ['created_by' => Auth::id()];
            if(empty($data['user_id']) || $data['user_id'] == null)
                $data['user_id'] = Auth::id();
            Order::create($data);
            DB::commit();
            return response()->json(['message' => 'Successfully created new order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function edit(){
        DB::beginTransaction();
        try {
            $data = json_decode(\request()->data, true);
            $id = \request()->id;
            $email = request()->email;
            $product = request()->product;
            $ref = request()->ref;
            $customer = request()->first_name;
            if(Auth::user()->user_type === 0){
                if (\request()->hasFile('payment')) {
                    $path = request()->file('payment')->store('uploads/orders', 'public');
                    $data += ['receipt' => $path];
                }
            }
            else{
                $details = [
                    'customer' => $customer,
                    'title' => 'Mail from D&J Tailoring Shop',
                    'body' => 'This is to inform you that your order '.$product.' with reference # '.$ref.' has been '.$data['status'],
                ];
                Mail::to($email)->send(new \App\Mail\Mailing($details));
            }
            $data += ['modified_by', Auth::id()];
            Order::find($id)->update($data);
           
            DB::commit();
            return response()->json(['message' => 'Successfully updated the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            Order::find($id)->delete();
            DB::commit();
            return response()->json(['message' => 'Successfully deleted the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
}
