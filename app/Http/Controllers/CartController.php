<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_image')->find($request->id);

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
                Cart::add($product->id, $product->title, 1, $product->price, ['product_image' => (!empty($product->product_image)) ? $product->product_image->first() : '']);

                $status = true;
                $massege = $product->title . ' ditambahkan ke keranjang';
            } else {
                $status = false;
                $massege = $product->title . ' sudah ada di keranjang';
            }

        } else {
            Cart::add($product->id, $product->title, 1, $product->price, ['product_image' => (!empty($product->product_image)) ? $product->product_image->first() : '']);
            $status = true;
            $massege = $product->title . ' ditambahkan ke keranjang';
        }

        return response()->json([
            'status' => $status,
            'message' => $massege,
        ]);
    }
    public function cart()
    {
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
            //         dd($cartContent);
            // exit();
        return view('front.cart', $data);
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
            $message = 'Stok item hanya (' . $qty-1 . ')';
            session()->flash('error', $message);
            $status = false;
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

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
}
