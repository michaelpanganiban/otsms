<?php

namespace App\Http\Controllers;

use App\Models\ProductSale;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetails extends Controller
{
    public function index(){
        $id = request()->route('id');
        $data = ProductSale::find($id);
        $rating = Rating::where('product_id', $id)->where('user_id', Auth::id())->get()->last();
        $all_rating = Rating::where('product_id', $id)->get();
        $reviews = Review::where('product_id', $id)->get();
        return view('view-product-details', compact('data', 'rating', 'all_rating', 'reviews'));
    }

    public function rate(){
        $data = [
            "product_id" => request()->product_id,
            "rating" => request()->value,
            "user_id" => Auth::id()
        ];
        if(Rating::create($data))
            return response()->json(['message' => 'Success'], 200);
        else
            return response()->json(['message' => 'error'], 500);
    }

    public function addReview(){
        $data = request()->data;
        $data+= ['user_id' => Auth::id()];
        if(Review::create($data))
            return 1;
        return 0;
    }
}
