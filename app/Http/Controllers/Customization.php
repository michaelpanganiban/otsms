<?php

namespace App\Http\Controllers;

use App\Models\Customization as ModelsCustomization;
use App\Models\Measurement as ModelsMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helper\Helper;

class Customization extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user_id = Auth::id();
        if(Auth::user()->user_type === 0)
            $data = DB::select("SELECT c.custom_id, c.status as c_status, c.reference_id, c.garment_type, c.details,c.user_id, c.pickup_date,c.fullpayment,c.price, c.proof_of_payment, c.downpayment, u.*, m.shoulder_length, m.sleeve_length, m.bust_chest, m.waist, m.skirt_length, m.slack_length, m.slack_front_rise, m.slack_fit_seat, m.slack_fit_thigh, m.measurement_id, c.design FROM customization c LEFT JOIN users u ON c.user_id = u.id LEFT JOIN measurement m ON c.custom_id = m.custom_id WHERE c.user_id = '$user_id'");
        else
        $data = DB::select("SELECT c.custom_id, c.status as c_status, c.reference_id, c.garment_type, c.details,c.user_id, c.pickup_date,c.fullpayment,c.price, c.proof_of_payment, c.downpayment, u.*, m.shoulder_length, m.sleeve_length, m.bust_chest, m.waist, m.skirt_length, m.slack_length, m.slack_front_rise, m.slack_fit_seat, m.slack_fit_thigh, m.measurement_id, c.design FROM customization c LEFT JOIN users u ON c.user_id = u.id LEFT JOIN measurement m ON c.custom_id = m.custom_id");
        return view('customization', compact('data'));
    }

    public function add(){
        DB::beginTransaction();
        try {
            $data = json_decode(\request()->data, true);
            $path = request()->file('design')->store('uploads/customization', 'public');
            $data += ['proof_of_payment' => $path];
            $data += ['user_id' => Auth::id()];
            $data += ['reference_id' => 'C-'.Date('Ymdss')];
            $custom = ModelsCustomization::create($data);
            // measurement -----
            if($data['garment_type'] !== 'Jersey') {
                $measerment = json_decode(request()->measurement, true);
                $measerment += ['custom_id' => $custom->custom_id];
                $measerment += ['user_id' => Auth::id()];
                $measerment += ['created_by' => Auth::id()];
                ModelsMeasurement::create($measerment);
            }
            // Notification ----------------------------------------------------------
                $details = 'An order was successfully created with reference # '.$data['reference_id'];
                $type='Both';
                $link='/customization';
                $user_id= Auth::id();
                $helper = new Helper();
                $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
            // Notification ----------------------------------------------------------
            DB::commit();
            return response()->json(['message' => 'Successfully created the order.'], 200);
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
            $measurement_id = request()->measurement_id;
            $pickup_date = '';
            $pick_date = request()->pick_date;
            $ref = request()->reference_id;
            $customer = request()->first_name;
            $contact_no = request()->contact_no;
            $email = request()->email;
            $customer_id = request()->customer_id;
            if(Auth::user()->user_type === 0){
                if (\request()->hasFile('design')) {
                    $path = request()->file('design')->store('uploads/customization', 'public');
                    $data += ['design' => $path];
                }
                if (\request()->hasFile('proof')) {
                    $path = request()->file('proof')->store('uploads/customization/proof-of-payment', 'public');
                    $data += ['proof_of_payment' => $path];
                }
                if($data['garment_type'] !== 'Jersey') {
                    $measurement = json_decode(request()->measurement, true);
                    $measurement += ['custom_id' => $id];
                    $measurement += ['user_id' => Auth::id()];
                    $measurement += ['created_by' => Auth::id()];
                    ModelsMeasurement::updateOrCreate([
                        'measurement_id' => $measurement_id
                    ],$measurement);;
                }
                // Notification ----------------------------------------------------------
                    $details = 'An order has been updated with reference # '. $ref;
                    $type='Admin';
                    $link='/customization';
                    $user_id= Auth::id();
                    $helper = new Helper();
                    $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
                // Notification ----------------------------------------------------------
            }
            else {
                if(trim($data['status']) == 'Active')
                    $pickup_date = 'Pickup date: '. date_format(date_create($pick_date), 'M d, Y');
                $details = [
                    'customer' => $customer,
                    'title' => 'Mail from D&J Tailoring Shop',
                    'body' => 'This is to inform you that your customized order with reference # '.$ref.' has been '.$data['status'].''.$pickup_date,
                ];
                Mail::to($email)->send(new \App\Mail\Mailing($details));
                $ch = curl_init();
                $itexmo = array(
                                    '1' => $contact_no, 
                                    '2' => 'Your order w/ ref # '.$ref.' has been '.$data['status'].'. '.$pickup_date, 
                                    '3' => 'TR-D&AMP153567_MJHVB', 
                                    'passwd' => '1en])(r8yj'
                                );
                curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_exec ($ch);
                curl_close ($ch); 
                // Notification ----------------------------------------------------------
                    $details = 'Your order w/ ref # '.$ref.' has been '.$data['status'].' '.$pickup_date;
                    $type='Customer';
                    $link='/customization';
                    $user_id= $customer_id;
                    $helper = new Helper();
                    $helper->addNotification($details, $type, $notif_read=0, $link, $user_id);
                // Notification ----------------------------------------------------------
            }
            ModelsCustomization::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            ModelsCustomization::find($id)->delete();
            DB::commit();
            return response()->json(['message' => 'Successfully deleted the order.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function guide(){
        return view('view-measurement-guide');
    }

    public function cancel(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            $ref = \request()->ref;
            ModelsCustomization::find($id)->update(['status' => 'Cancelled']);
            // Notification ----------------------------------------------------------
                $details = 'An Customized order w/ ref # '.$ref.' has been cancelled.';
                $type='Admin';
                $link='/customization';
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
