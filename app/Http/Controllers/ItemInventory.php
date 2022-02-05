<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemInventory extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('inventory');
    }

    public function add(){
        DB::beginTransaction();
        try{
            $data = \request()->all();
            $data += ['created_by' => Auth::id()];
            Inventory::create($data);
            DB::commit();
            return response()->json(['message' => 'Successfully created new item.'], 200);
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
            Inventory::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the item.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            Inventory::find($id)->update(['status' => 'Inactive']);
            DB::commit();
            return response()->json(['message' => 'Successfully deactivated the item.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function stockIn(){
        DB::beginTransaction();
        try {
            $data = \request()->data;
            $id = \request()->id;
            Inventory::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the item quantity.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
}
