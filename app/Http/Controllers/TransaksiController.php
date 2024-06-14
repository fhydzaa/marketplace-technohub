<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = session('user', Auth::user());
        $user = Auth::user();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['userdetails'] = $userdetails;
        return view('front.transaksi', $data, ['user' => $user]);
    }
}
