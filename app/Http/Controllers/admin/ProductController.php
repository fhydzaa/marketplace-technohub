<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.page');
    }
    public function create()
    {
        $data = [];
        return view('admin.product.buat', $data);
    }

    public function store(Request $request)
    {
        // dd($request->image_array);
        // exit();
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->save();

            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {
                    $tempImageInfo = TempImages::find($temp_image_id);

                    // Pastikan bahwa tempImageInfo tidak null
                    if (!$tempImageInfo) {
                        continue; // Lanjutkan ke iterasi berikutnya jika tidak ditemukan
                    }

                    $extArray = explode('.', $tempImageInfo->name);
                    $ext = last($extArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext;
                    $productImage->image = $imageName;
                    $productImage->save();

                    $sourcePath = public_path() . '/temp/' . $tempImageInfo->name;

                    // Periksa apakah source path ada
                    if (!file_exists($sourcePath)) {
                        continue; // Lanjutkan ke iterasi berikutnya jika file tidak ditemukan
                    }

                    $manager = new ImageManager(new Driver());

                    // Proses gambar ukuran besar
                    $destLargePath = public_path() . '/uploads/product/large/' . $imageName;
                    $image = $manager->read($sourcePath);
                    $image->scale(1400);
                    $image->save($destLargePath);

                    // Proses gambar ukuran kecil
                    $destSmallPath = public_path() . '/uploads/product/small/' . $imageName;
                    $image = $manager->read($sourcePath);
                    $image->scale(300, 275);
                    $image->save($destSmallPath);
                }
            }

            return response()->json([
                'status' => true,
                'success' => 'Product added'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
