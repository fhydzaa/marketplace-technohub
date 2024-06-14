<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails as ModelsUserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'gender' => 'required|string',
            'no_telephone' => 'required',
            'base64Image' => 'nullable|string',
        ]);

        $base64Image = $request->input('base64Image', null);

        // Gunakan gambar default jika base64Image kosong
        if (empty($base64Image)) {
            $defaultImagePath = public_path('front-assets/img/avatar5.png');
            if (file_exists($defaultImagePath)) {
                $base64Image = base64_encode(file_get_contents($defaultImagePath));
            }
        }

        $userDetails = new ModelsUserDetails();
        $userDetails->user_id = $request->user_id;
        $userDetails->image = $base64Image;
        $userDetails->gender = $request->gender;
        $userDetails->no_telephone = $request->no_telephone;
        $userDetails->save();

        session()->flash('success', 'Profil berhasil ditambahkan');

        return redirect()->route('front.home')
            ->with('success', 'Profil berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userDetails = ModelsUserDetails::where('user_id', $request->user_id)->first();
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required|string',
            'no_telephone' => 'required',
            'base64Image' => 'nullable|string',
        ]);

        $base64Image = $request->input('base64Image', null);

        // Gunakan gambar default jika base64Image kosong
        if (empty($base64Image)) {
            $defaultImagePath = public_path('front-assets/img/avatar5.png');
            if (file_exists($defaultImagePath)) {
                $base64Image = base64_encode(file_get_contents($defaultImagePath));
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $userDetails->user_id = $request->user_id;
        $userDetails->image = $base64Image;
        $userDetails->gender = $request->gender;
        $userDetails->no_telephone = $request->no_telephone;
        $userDetails->save();

        session()->flash('success', 'Profil berhasil diupdate');

        return redirect()->route('account.profileEdit', $user->id)
            ->with('success', 'Profil berhasil diupdate');
    }
}
