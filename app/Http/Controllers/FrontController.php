<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get();
        
        

        $data['product'] = $product;

        $user = Auth::user();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['userdetails'] = $userdetails;
        
        $user = session('user', Auth::user());
            // dd($data);
            // exit();
        return view('front.home', $data, ['user' => $user]);
    }
}
