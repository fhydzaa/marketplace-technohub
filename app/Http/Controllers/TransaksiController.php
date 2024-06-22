<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\productLisense;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Models\TransactionLisense;
use Gloudemans\Shoppingcart\Facades\Cart;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->with('product')->orderBy('id', 'DESC')->paginate(10);
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $transaction_details = TransactionDetails::with('transactionLicense')->get();
        // Mengambil semua lisensi yang terkait dengan transaksi pengguna

        $data['transaction'] = $transactions;
        $data['userdetails'] = $userdetails;
        $data['transaction_details'] = $transaction_details;
        // $transactionLicenseMap->each(function ($item) {
        //     dd($item->transaction_license_id); // Ini akan menampilkan setiap transaction_license_id
        // }); 
        // dd($transaction_details);     
        return view('front.transaksi', $data, ['user' => $user]);
    }


    public function process(Request $request)
    {

        $user = Auth::user();
        $userIdStr = strval($user->id);
        $randomStr = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10 - strlen($userIdStr));
        $noOrder = $userIdStr . $randomStr;

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->id_order = $noOrder;
        $transaction->status = 'pending';
        $transaction->sanp_token = '';
        $transaction->total_price = $request->subtotal;
        $transaction->save();

        Cart::destroy();
        // Store cart
        if (Auth::check()) {
            Cart::store(Auth::user()->name);
        }

        if ($request->products) {
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
        } else {
            $product = Product::findOrFail($request->productId);
            $transaction->product()->attach($product, [
                'qty' => $request->qty
            ]);
        }

        return response()->json([
            'status' => true,
            'massege' => 'Silahkan bayar pesanan anda'
        ]);
    }

    public function pay(Request $request)
    {
        $user = Auth::user();

        $userdetails = UserDetails::where('user_id', $user->id)->first();

        $transaction = Transaction::where('id', $request->transactionId)->first();
        // Set your Merchant Server Key
        // \Midtrans\Config::$serverKey = "SB-Mid-server-fLRCa8dPfavwqJpXZxqETIKZ";
        \Midtrans\Config::$serverKey = config('midtrans.serverkey');
        \Midtrans\Config::$isProduction = false; // Set to true for Production Environment
        \Midtrans\Config::$isSanitized = true; // Set sanitization on
        \Midtrans\Config::$is3ds = true; // Set 3DS transaction for credit card to true

        $params = array(
            'transaction_details' => array(
                'order_id' => uniqid(),
                'gross_amount' => $transaction->total_price,
            ),
            'customer_details' => array(
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $userdetails->no_telephone,
            ),
        );

        $snap_token = \Midtrans\Snap::getSnapToken($params);


        $transaction->sanp_token = $snap_token;
        $transaction->save();

        return response()->json([
            'status' => true,
            'snap_token' => $snap_token
        ]);
    }

    public function status($transaction)
    {

        // $user = Auth::user();
        // $product = Product::where('status', 1)->get();

        $transaction = Transaction::where('id', $transaction)->first();
        $transaction->status = 'success';
        $transaction->save();


        foreach ($transaction->product as $prod) {
            // dd($prod->pivot->id,$prod->pivot->qty );
            // exit();
            $product_license = productLisense::where('product_id', $prod->id)->take($prod->pivot->qty)->get();
            foreach ($product_license as $prod_lis) {
                $trans_lis = new TransactionLisense();
                $trans_lis->transaction_details_id = $prod->pivot->id;
                $trans_lis->license = $prod_lis->license;
                $trans_lis->save();

                $prod_lis->delete();
            }
        }

        foreach ($transaction->product as $prod) {
            // dd($prod->pivot->id,$prod->pivot->qty );
            // exit();
            $prod->qty -= $prod->pivot->qty;
            $prod->save();
        }

        // foreach ($transaction->transaction_details as $detail) {
        //     foreach ($product as $prod) {
        //         if ($prod->id == $detail->product_id) {
        //             $prod->qty -= $detail->qty;
        //             $prod->save();
        //         }
        //     }
        // }

        session()->flash('success', 'Produk berhasil dibeli');
        return redirect()->route('front.transaksi');
    }
}
