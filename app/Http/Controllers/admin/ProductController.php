<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\productLisense;
use App\Models\TempImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::latest('id')->with('product_image');

        if (!empty($request->get('search'))) {
            $search = $request->get('search');
            $product = $product->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        // if(!empty($request->get('search'))){
        //     $product = $product->where('title','like','%'.$request->get('search').'%');
        // } 



        $product = $product->orderBy('id', 'DESC');

        $product = $product->paginate(6);

        $data['product'] = $product;
        // dd($data);
        // exit();
        return view('admin.product.page', $data);
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
            'qty' => 'required|integer|max:100'
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

            function generateLicenseKey() {
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $segments = [];
                for ($i = 0; $i < 4; $i++) {
                    $segment = '';
                    for ($j = 0; $j < 4; $j++) {
                        $segment .= $chars[rand(0, strlen($chars) - 1)];
                    }
                    $segments[] = $segment;
                }
                return implode('-', $segments);
            }

            foreach (range(1, $request->qty) as $index) {
                $licenseKey = generateLicenseKey(); // Menghasilkan lisensi acak
        
                // Simpan lisensi ke dalam database
                $productLicense = new productLisense();
                $productLicense->product_id = $product->id;
                $productLicense->license = $licenseKey;
                $productLicense->save();
            }

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
            $request->session()->flash('success', 'Product berhasil ditambahkan');
            return response()->json([
                'status' => true,
                'success' => 'Product added'
            ]);
        } else {
            $request->session()->flash('error', 'Product gagal ditambahkan');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit($id, Request $request)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return redirect()->route('product.index')->with('error', 'produk tidak ditemukan');
        }
        $productImages = ProductImage::where('product_id', $product->id)->get();
        $data['product'] = $product;
        $data['productImages'] = $productImages;
        return view('admin.product.edit', $data);
    }

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $productLicense = productLisense::where('product_id', $id)->count();

        // dd($request->image_array);
        // exit();
        $rules = [
            'title' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->save();

            function generateLicenseKey() {
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $segments = [];
                for ($i = 0; $i < 4; $i++) {
                    $segment = '';
                    for ($j = 0; $j < 4; $j++) {
                        $segment .= $chars[rand(0, strlen($chars) - 1)];
                    }
                    $segments[] = $segment;
                }
                return implode('-', $segments);
            }

            if($productLicense<$request->qty){
                foreach (range(1, $request->qty-$productLicense) as $index) {
                    $licenseKey = generateLicenseKey(); // Menghasilkan lisensi acak
            
                    // Simpan lisensi ke dalam database
                    $productLicense = new productLisense();
                    $productLicense->product_id = $product->id;
                    $productLicense->license = $licenseKey;
                    $productLicense->save();
                }
            } else {
                $product_license = productLisense::where('product_id', $product->id)->take($productLicense-$request->qty)->get();
                foreach ($product_license as $prod_lis) {
                    $prod_lis->delete();
                }
            }
            

            $request->session()->flash('success', 'Product berhasil diupdate');

            return response()->json([
                'status' => true,
                'success' => 'Product berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id, Request $request)
    {
        $product = Product::find($id);

        if (empty($product)) {
            $request->session()->flash('error', 'Produk tidak ada');
            return response()->json([
                'status' => false,
                'notFound' => true
            ]);
        }

        $productImages = ProductImage::where('product_id', $id)->get();

        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                // Delete small image
                unlink(public_path('uploads/product/small/' . $productImage->image));
                // Delete large image
                unlink(public_path('uploads/product/large/' . $productImage->image));
            }

            ProductImage::where('product_id', $id)->delete();
        }

        $product->delete();

        $request->session()->flash('success', 'Produk berhasil dihapus');

        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil dihapus'
        ]);
    }
    public function removeImage(Request $request)
    {
        $imageId = $request->input('image_id');

        // Retrieve the image details from the database using the image id
        // dd($imageId);
        // exit();
        $productImage = ProductImage::find($imageId);
        if (!empty($productImage)) {
            // Delete small image
            unlink(public_path('uploads/product/small/' . $productImage->image));
            // Delete large image
            unlink(public_path('uploads/product/large/' . $productImage->image));

            // Delete the record from the database
            $productImage->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    // public function removeImage($id, Request $request)
    // {
    //     $product = Product::find($id);

    //     if (empty($product)) {
    //         $request->session()->flash('error', 'Produk tidak ada');
    //         return response()->json([
    //             'status' => false,
    //             'notFound' => true
    //         ]);
    //     }


    //     // Retrieve the image details from the database using the image id
    //     $productImages = ProductImage::where('product_id', $id)->get();

    //     if (!empty($productImages)) {
    //         foreach ($productImages as $productImage) {
    //             // Delete small image
    //             unlink(public_path('uploads/product/small/' . $productImage->image));
    //             // Delete large image
    //             unlink(public_path('uploads/product/large/' . $productImage->image));
    //         }

    //         ProductImage::where('product_id', $id)->delete();
    //     }

    //     return response()->json(['success' => false]);
    // }
}
