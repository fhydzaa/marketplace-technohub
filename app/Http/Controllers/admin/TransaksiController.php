<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaction = Transaction::with('user');
        if (!empty($request->get('search'))) {
            $search = $request->get('search');
            $transaction = $transaction->where(function ($query) use ($search) {
                $query->where('status', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $transaction = $transaction->orderBy('id', 'DESC');

        $transaction = $transaction->paginate(10);

        $data['transaction'] = $transaction;
        return view('admin.transaksi', $data);
    }

    // public function index(Request $request)
    // {
    //     // Ambil pengguna dengan role 1 dan eager load transaksi
    //     $users = User::with('transactions')
    //                     ->where('role', 1)
    //                     ->get();

    //     // Inisialisasi koleksi transaksi
    //     $transactions = collect();

    //     // Iterasi setiap pengguna dan tambahkan transaksi ke koleksi
    //     foreach ($users as $user) {
    //         $transactions = $transactions->merge($user->transactions);
    //     }

    //     // Filter berdasarkan pencarian jika ada
    //     if (!empty($request->get('search'))) {
    //         $search = $request->get('search');
    //         $transactions = $transactions->filter(function ($transaction) use ($search) {
    //             return stripos($transaction->status, $search) !== false ||
    //                    stripos($transaction->name, $search) !== false; // Sesuaikan dengan struktur tabel Anda
    //         });
    //     }

    //     // Urutkan transaksi berdasarkan id secara descending
    //     $transactions = $transactions->sortByDesc('id');

    //     // Mengembalikan data ke view
    //     $data['transaction'] = $transactions;
    //     return view('admin.transaksi', $data);
    // }
}
