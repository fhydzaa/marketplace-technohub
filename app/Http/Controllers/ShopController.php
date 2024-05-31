<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request){
        $product = Product::where('status',1);

        if(!empty($request->get('search'))){
            $product = $product->where('title','like','%'.$request->get('search').'%');
        } 
        
        $product = $product->orderBy('id','DESC');
        $product = $product->get();

        $data['product'] =$product;
        $user = session('user', Auth::user());

        return view('front.shop', $data,['user' => $user]);
    }

    public function product($slug){
        // $product = Product::where('slug',$slug)->with('product_image')->first();
        $product = Product::where('slug',$slug)->first();
        if($product == NULL){
            abort(404);
        }
        $data['product'] =$product;
        $user = session('user', Auth::user());
        return view('front.product', $data, ['user' => $user]);
    }
}