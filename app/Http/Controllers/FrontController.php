<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::select('product.id','product.title','product.slug','product.price','product.qty','product.description', DB::raw('COUNT(transaction_details.product_id) as success_count'))
            ->join('transaction_details', 'product.id', '=', 'transaction_details.product_id')
            ->join('transaction', 'transaction_details.transaction_id', '=', 'transaction.id')
            ->where('transaction.status', 'success')
            ->groupBy('product.id','product.title','product.slug','product.price','product.qty','product.description')
            ->orderBy('success_count', 'DESC')
            ->take(6)
            ->get();
        $data['product'] = $product;

        if (Auth::user()) {
            $user = Auth::user();

            $userdetails = UserDetails::where('user_id', $user->id)->get();
            $data['userdetails'] = $userdetails;

            return view('front.home', $data, ['user' => $user]);
        }

        return view('front.home', $data);
    }
}
