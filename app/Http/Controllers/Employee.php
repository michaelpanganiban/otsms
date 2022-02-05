<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Employee extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('employee/employeeList');
    }

    public function add(){
        DB::beginTransaction();
        try{
            $data = \request()->data;
            $data += ['created_by' => Auth::id()];
            $data += ['password' => Hash::make('00000')];
            User::create($data);
            DB::commit();
            return response()->json(['message' => 'Successfully created new employee.'], 200);
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
            User::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the employee data.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            User::find($id)->update(['status' => 'Inactive']);
            DB::commit();
            return response()->json(['message' => 'Successfully deactivated the employee.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function addSchedule(){
        DB::beginTransaction();
        try{
            $data = \request()->data;
            EmployeeSchedule::where('user_id', $data[0]['user_id'])->delete();
            for($i = 0; $i < sizeof($data); $i++){
                $data[$i] += ['create_by' => Auth::id()];
            }
            EmployeeSchedule::insert($data);
            DB::commit();
            return response()->json(['message' => 'Successfully created a schedule.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function getSchedule(){
        $id = request()->id;
        return response()->json(EmployeeSchedule::where('user_id', $id)->get());
    }
}
