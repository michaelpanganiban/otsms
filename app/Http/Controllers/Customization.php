<?php

namespace App\Http\Controllers;

use App\Models\Customization as ModelsCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customization extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->user_type === 0)
            $data = ModelsCustomization::with(
                ['user'=> function($users){$users->select('*');}]
            )->where('user_id', Auth::id())->get();
        else
            $data = ModelsCustomization::with(
                ['user'=> function($users){$users->select('*');}]
            )->get();
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
            ModelsCustomization::create($data);
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
            if(Auth::user()->user_type === 0){
                if (\request()->hasFile('design')) {
                    $path = request()->file('design')->store('uploads/customization', 'public');
                    $data += ['proof_of_payment' => $path];
                }
            }
            ModelsCustomization::find($id)->update($data);
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
}
