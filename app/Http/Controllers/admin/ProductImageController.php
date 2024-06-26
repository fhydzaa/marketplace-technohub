<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $tempImageLocation = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id . '-' . $productImage->id . '-' . time() . '.' . $ext;
        $productImage->image = $imageName;
        $productImage->save();

        $sourcePath = $tempImageLocation;

        // // Periksa apakah source path ada
        // if (!file_exists($sourcePath)) {
        //     continue; // Lanjutkan ke iterasi berikutnya jika file tidak ditemukan
        // }

        $manager = new ImageManager(new Driver());

        // Proses gambar ukuran besar
        $destLargePath = public_path() . '/uploads/product/large/' . $imageName;
        $image = $manager->read($sourcePath);
        $image->scale(1400);
        $image->save($destLargePath);

        // Proses gambar ukuran kecil
        $destSmallPath = public_path() . '/uploads/product/small/' . $imageName;
        $image = $manager->read($sourcePath);
        $image->scale(300, 300);
        $image->save($destSmallPath);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('upload/product/small'.$productImage->image ),
            'success' => 'Image saved'
        ]);
    }
}
