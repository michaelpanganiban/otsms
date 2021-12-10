<?php

namespace App\Http\Controllers;

use App\Models\Measurement as ModelsMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Measurement extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(!empty(request()->query('id')))
            $data = ModelsMeasurement::where('user_id', request()->query('id'))->get();
        else
            $data = ModelsMeasurement::where('user_id', Auth::id())->get();
        return view('measurement', compact('data'));
    }

    public function add(){
        DB::beginTransaction();
        try{
            $data = \request()->data;
            $data += ['created_by' => Auth::id()];
            $data += ['user_id' => Auth::id()];
            ModelsMeasurement::updateOrCreate([
                'user_id' => Auth::id()
            ],$data);
            DB::commit();
            return response()->json(['message' => 'Successfully added your measurement.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
}
