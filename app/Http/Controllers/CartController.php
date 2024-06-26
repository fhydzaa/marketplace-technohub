<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserDetails;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_image')->find($request->id);

        // if (!Auth::check()) {
        //     session()->flash('error', 'Silahkan login terlebih dahulu');
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Silahkan login terlebih dahulu'
        //     ]);
        // }

        if ($product == NULL) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found'
            ]);
        }

        if (Cart::count() > 0) {
            $cartContent = Cart::Content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }

            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->title, $request->qtyValue, $product->price, ['product_image' => (!empty($product->product_image)) ? $product->product_image->first() : '']);

                $status = true;
                $massege = $request->qtyValue .  ' item ' . $product->title . ' ditambahkan ke keranjang';
            } else {
                $status = false;
                $massege = $product->title . ' sudah ada di keranjang' ;
            }
        } else {
            Cart::add($product->id, $product->title, $request->qtyValue, $product->price, ['product_image' => (!empty($product->product_image)) ? $product->product_image->first() : '']);
            $status = true;
            $massege = $request->qtyValue .  ' item ' . $product->title . ' ditambahkan ke keranjang';
        }

        // Store cart
        if (Auth::check()) {
            Cart::store(Auth::user()->name);
        }

        return response()->json([
            'status' => $status,
            'message' => $massege,
        ]);
    }
    public function cart()
    {
        if (Auth::check()) {
            Cart::restore(Auth::user()->name);
        }

        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        //         dd($cartContent);
        // exit();  
        $user = Auth::user();
        $userdetails = UserDetails::where('user_id', $user->id)->get();
        $data['userdetails'] = $userdetails;
        $clientKey = config('midtrans.clientkey');
        //         dd($clientKey   );
        // exit();  
        return view('front.cart', $data, ['user' => $user, 'clientKey' => $clientKey]);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);

        if ($qty <= $product->qty) {
            Cart::update($rowId, $qty);
            $message = 'Keranjang berhasil diupdate';
            session()->flash('success', $message);
            $status = true;
        } else {
            $message = 'Stok item hanya (' . $qty - 1 . ')';
            session()->flash('error', $message);
            $status = false;
        }

        // Store cart
        if (Auth::check()) {
            Cart::store(Auth::user()->name);
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteCart(Request $request)
    {
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);
        if ($itemInfo == NULL) {
            session()->flash('error', 'Item tidak ditemukan di keranjang');
            return response()->json([
                'status' => false,
                'message' => 'Item tidak ditemukan di keranjang'
            ]);
        }


        Cart::remove($request->rowId);
        $message = 'Item dihapus dari keranjang';
        session()->flash('error', $message);

        // Store cart
        if (Auth::check()) {
            Cart::store(Auth::user()->name);
        }

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
