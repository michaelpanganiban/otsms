<?php

namespace App\Http\Controllers;

use App\Models\ProductSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
class Sales extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('garments/sales');
    }

    public function add(){
        DB::beginTransaction();
        try{
            // $path = \request()->file('image')->store('uploads/products', 'public');
            // $path = \Storage::disk('public_uploads')->put('products', \request()->file('image'));
            $path = '';
            if (\request()->hasFile('image')) {
                $filename = Date('Hmis').$_FILES["image"]["name"];
                $path = 'products/'.$filename;
                $dir = 'assets/uploads/'.$path;
                move_uploaded_file($_FILES["image"]["tmp_name"], $dir);
            }
            $data = json_decode(\request()->data, true);
            $data['product_name'] = preg_replace("/'/", '', $data['product_name']); 
            // $data['product_name'] = preg_replace('/[^A-Za-z0-9\-]/', '', $data['product_name']); 
            $data += ["image" => $path];
            $data += ['create_by' => Auth::id()];
            ProductSale::create($data); //add data to database
            DB::commit();
            return response()->json(['message' => 'Successfully created new product.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit(){
        DB::beginTransaction();
        try {
            $data = json_decode(\request()->data, true);
            $id = \request()->id;
            if (\request()->hasFile('image')) {
                // $old_path = ProductSale::find($id)->pluck('image')->first();
                // File::delete(public_path('storage/' . $old_path));
                // $path = request()->file('image')->store('uploads/products', 'public');
                // $path = \Storage::disk('public_uploads')->put('products', \request()->file('image'));
                $filename = Date('Hmis').$_FILES["image"]["name"];
                $path = 'products/'.$filename;
                $dir = 'assets/uploads/'.$path;
                move_uploaded_file($_FILES["image"]["tmp_name"], $dir);
                $data += ['image' => $path];
            }
            // return $path;
            ProductSale::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated the product.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function delete(){
        DB::beginTransaction();
        try {
            $id = \request()->id;
            ProductSale::find($id)->update(['status' => 'Inactive']);
            DB::commit();
            return response()->json(['message' => 'Successfully deactivated the product.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function rent(){
        return view('garments/rent');
    }
}
