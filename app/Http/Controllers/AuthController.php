<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
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
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'Registrasi Success');

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
        $remember = $request->get('remember', false);
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
                $authenticatedUser = Auth::user();
                $userDetails = UserDetails::where('user_id', $authenticatedUser->id)->first();
                if ($userDetails) {
                    // Pengguna lama: Redirect ke front.home
                    return redirect()->route('front.home');
                } else {
                    // Pengguna baru: Redirect ke account.profile
                    session()->flash('success', 'Login berhasil!');
                    return redirect()->route('account.profile')->with('success', 'Login berhasil!');
                }
                // return view('front.home');
            } else {
                session()->flash('error', 'Login gagal, cek email dan password');
                return redirect()->route('account.login')->with('error', 'Login gagal, cek email dan password');
            }
        } else {
            session()->flash('error', 'Login gagal, cek email dan password');
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile(){
        $user = session('user', Auth::user());
        $user = Auth::user();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['userdetails'] = $userdetails;
        return view('front.account.profile',$data, ['user' => $user]);
    }

    public function profileEdit(){
        $user = session('user', Auth::user());
        $user = Auth::user();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['userdetails'] = $userdetails;
        // dd($data);
        // exit();
        return view('front.account.profileEdit',$data, ['user' => $user]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')
        ->with('success','Kamu berhasil logout');
    }
}
