<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Transaction;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transaction = Transaction::where('user_id', $user->id)->get();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['transaction'] = $transaction;
        $data['userdetails'] = $userdetails;
        return view('front.transaksi', $data, ['user' => $user]);
    }

    public function process(Request $request)
    {

        $user = Auth::user();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->status = 'pending';
        $transaction->sanp_token = '';
        $transaction->total_price = $request->subtotal;
        $transaction->save();

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404); // Atau kode status yang sesuai
            }
            // Simpan relasi many-to-many
            $transaction->product()->attach($product, [
                'qty' => $productData['qty']
            ]);
        }

        return response()->json([
            'status' => true,
            'massege' => 'Silahkan bayar pesanan anda'
        ]);
    }

    public function pay(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = "SB-Mid-server-fLRCa8dPfavwqJpXZxqETIKZ";
        \Midtrans\Config::$isProduction = false; // Set to true for Production Environment
        \Midtrans\Config::$isSanitized = true; // Set sanitization on
        \Midtrans\Config::$is3ds = true; // Set 3DS transaction for credit card to true

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->price,
            ),
            'customer_details' => array(
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $userdetails->no_telephone,
            ),
        );

        $snap_token = \Midtrans\Snap::getSnapToken($params);

        $user->product()->updateExistingPivot($product->id, [
            'sanp_token' => $snap_token,
        ]);

        return response()->json([
            'status' => true,
            'snap_token' => $snap_token
        ]);
    }
}
