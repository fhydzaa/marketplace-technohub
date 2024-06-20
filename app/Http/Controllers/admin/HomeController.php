<?php

namespace App\Http\Controllers\admin;

use App\Charts\MonthlyUsersChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(MonthlyUsersChart $chart)
    {
        $transaction = Transaction::with('user');

        $transaction = $transaction->orderBy('id', 'DESC');

        $transaction = $transaction->get();

        $data['transaction'] = $transaction;

        $data['chart'] = $chart->build();


        return view('admin.dashboard', $data);
        // $admin = Auth::guard('admin')->user();
        // echo 'Welcome'.$admin->name.'<a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
