<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index(){
        if(Auth::user()){
            $user = Auth::user();

            $userdetails = UserDetails::where('user_id', $user->id)->get();
            $data['userdetails'] = $userdetails;

            return view('front.about', $data, ['user' => $user]);
        }
        return view('front.about');
    }
}
