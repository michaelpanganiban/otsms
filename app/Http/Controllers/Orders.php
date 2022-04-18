<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helper\Helper;

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
            // Notification ----------------------------------------------------------
            $details = 'An order was successfully created with reference # '.$data['reference_id'];
            $type='Both';
            $link='/orders';
            $user_id= $data['user_id'];
            $helper = new Helper();
            $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
            // Notification ----------------------------------------------------------
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
            $pickup_date = '';
            $data = json_decode(\request()->data, true);
            $id = \request()->id;
            $email = request()->email;
            $product = request()->product;
            $ref = request()->ref;
            $customer = request()->first_name;
            $customer_id = request()->customer_id;
            $contact_no = request()->contact_no;
            $pick_date = request()->pick_date;
            if(Auth::user()->user_type === 0){
                if (\request()->hasFile('payment')) {
                    // $path = request()->file('payment')->store('uploads/orders', 'public');
                    $filename = Date('Hmis').$_FILES["payment"]["name"];
                    $path = 'orders/'.$filename;
                    $dir = 'assets/uploads/'.$path;
                    move_uploaded_file($_FILES["payment"]["tmp_name"], $dir);
                    $data += ['receipt' => $path];
                }
                // Notification ----------------------------------------------------------
                $details = 'An order has been updated with reference # '. $ref;
                $type='Admin';
                $link='/orders';
                $user_id= Auth::id();
                $helper = new Helper();
                $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
                // Notification ----------------------------------------------------------
            }
            else{
                if(trim($data['status']) == 'Approved')
                    $pickup_date = '. Pickup date: '. date_format(date_create($pick_date), 'M d, Y');
                // $details = [
                //     'customer' => $customer,
                //     'title' => 'Mail from D&J Tailoring Shop',
                //     'body' => 'This is to inform you that your order '.$product.' with reference # '.$ref.' has been '.$data['status'].''.$pickup_date,
                // ];
                // Mail::to($email)->send(new \App\Mail\Mailing($details));
                $ch = curl_init();
                $itexmo = array(
                                    '1' => $contact_no, 
                                    '2' => 'Your order w/ ref # '.$ref.' has been '.$data['status'].''.$pickup_date, 
                                    '3' => 'TR-D&AMP234954_VZ4HD', 
                                    'passwd' => 'jv$]@7v6q}'
                                );
                curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec ($ch);
                curl_close ($ch);   
                // Notification ----------------------------------------------------------
                    $details = 'Your order w/ ref # '.$ref.' has been '.$data['status'].''.$pickup_date;
                    $type='Customer';
                    $link='/orders';
                    $user_id= $customer_id;
                    $helper = new Helper();
                    $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
                // Notification ----------------------------------------------------------
            }
            $data += ['modified_by', Auth::id()];
            Order::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updatePayment() {
        DB::beginTransaction();
        try {
            $id = request()->id;
            $data = request()->amount;
            Order::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Saved'], 200);
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

    public function cancel(){
        DB::beginTransaction();
        try {
            $id = \request()->order_id;
            $ref = \request()->ref;
            Order::find($id)->update(['status' => 'Cancelled']);
            // Notification ----------------------------------------------------------
                $details = 'An order w/ ref # '.$ref.' has been cancelled.';
                $type='Admin';
                $link='/orders';
                $user_id= Auth::id();
                $helper = new Helper();
                $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
            // Notification ----------------------------------------------------------
            DB::commit();
            return response()->json(['message' => 'Successfully cancelled the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
}
