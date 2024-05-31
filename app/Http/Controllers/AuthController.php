<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function register()
    {
        return view('front.account.register');
    }

    public function processRegister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'Registrasi berhasil');

            return response()->json([
                'status' => true,
            ]);
        } else {
            session()->flash('error', 'Registrasi gagal silahkan coba lagi');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                // $authenticatedUser = Auth::user();
                // $userFromDatabase = User::where('email', $authenticatedUser->email)->first();
                // // $account = Auth::guard('account')->user();
                // // if ($account->role == 2) {
                // //     return redirect()->route('account.dashboard');
                // // } else {
                // //     Auth::guard('account')->logout();
                // //     return redirect()->route('account.login')->with('error', 'You are not authorized to access account panel.');
                // // }
                // // dd($userName);
                // // exit();
                // $data['user'] =$userFromDatabase;
                return redirect()->route('front.home');
                // return view('front.home');
            } else {
                session()->flash('error', 'Login gagal, cek email dan password');
                return redirect()->route('account.login')->with('error', 'Login gagal, cek email dan password');
            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile(){
        $user = session('user', Auth::user());
        return view('front.account.profile', ['user' => $user]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')
        ->with('success','Kamu berhasil logout');
    }
}
