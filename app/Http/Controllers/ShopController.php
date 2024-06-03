<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\productRating;
use Illuminate\Support\Facades\Validator;
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
        $product = Product::where('slug', $slug)
        ->withCount('product_ratings')
        ->withSum('product_ratings', 'rating') // specify the column to sum
        ->with(['product_image', 'product_ratings'])
        ->first();
            // $product = Product::where('slug',$slug)->first();
        if($product == NULL){
            abort(404);
        }
        $avgRating = '0.00';
        $avgRatingPer = 0;
        if($product->product_ratings_count > 0){
            $avgRating = number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;
        $data['product'] = $product;
        $user = session('user', Auth::user());

        

        return view('front.product', $data, ['user' => $user]);
    }

    public function review($slug){
        $product = Product::where('slug', $slug)
        ->withCount('product_ratings')
        ->withSum('product_ratings', 'rating') // specify the column to sum
        ->with(['product_image', 'product_ratings'])
        ->first();
        if($product == NULL){
            abort(404);
        }
        $avgRating = '0.00';
        $avgRatingPer = 0;
        if($product->product_ratings_count > 0){
            $avgRating = number_format(($product->product_ratings_sum_rating/$product->product_ratings_count),2);
            $avgRatingPer = ($avgRating*100)/5;
        }

        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;
        $data['product'] =$product;
        $user = session('user', Auth::user());
        return view('front.review', $data, ['user' => $user]);
    }

    public function saveRating($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'comment' => 'required|min:10',
            'rating' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $productRating = new productRating;
        $productRating->product_id = $id;
        $productRating->username = $request->name;
        $productRating->email = $request->email;
        $productRating->comment = $request->comment;
        $productRating->rating = $request->rating;
        $productRating->status = 0;
        $productRating->save();

        session()->flash('success','Terimakasih telah menilai produk kami');

        return response()->json([
            'status' => true,
            'errors' => 'Terimakasih telah menilai produk kami'
        ]);
    }
}
