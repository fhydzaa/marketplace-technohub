@extends('admin.layouts.app') @section('content')
<div class="container d-flex align-items-center justify-content-center">
    <form
        class="d-flex flex-row justify-content-center align-items-center gap-4"
    >
        <div class="py-4" style="width: 500px">
            <input
                value="{{ Request::get('search') }}"
                type="text"
                class="form-control"
                id="search"
                name="search"
                placeholder="Cari Produk "
            />
              <!-- <input
                  value="{{ Request::get('search') }}"
                  name="search"
                  id="search"
                  type="text"
                  placeholder="Cari Produk"
              /> -->
        </div>
        <div class="py-4">
            <button type="submit" class="btn btn-primary rounded-4 px-4">
                Submit
            </button>
        </div>
    </form>
</div>

<div class="container bg-light h-100 mb-3 rounded-4">
    <div class="py-3">
        <a
            href="{{ route('product.buat') }}"
            class="ms-5 btn btn-primary rounded-4 px-4"
            >Add Product</a
        >
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" class="text-start">Id</th>
                <th scope="col" class="text-start">Gambar</th>
                <th scope="col" class="text-start">Product</th>
                <th scope="col" class="text-start">Jenis</th>
                <th scope="col" class="text-start">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($product->isNotEmpty()) @foreach ($product as $prod) @php
            $productImage = $prod->product_image->first(); @endphp
            <tr>
                <th class="align-middle text-start" scope="row">
                    {{ $prod->id }}
                </th>
                <td class="text-start">
                    @if (!empty($productImage->image))
                    <img
                        src="{{ asset('uploads/product/small/'.$productImage->image) }}"
                        class="card-img-top"
                        alt="Product"
                        style="width: 100px; height: 100px; object-fit: cover"
                    />
                    @else
                    <img
                        src="{{ asset('front-assets/img/product.png') }}"
                        class="card-img-top"
                        alt="Product"
                        style="width: 100%; height: 189px; object-fit: cover"
                    />
                    @endif
                </td>

                <td class="align-middle text-start">{{ $prod->title }}</td>
                <td class="align-middle text-start">{{ $prod->category }}</td>
                <td class="align-middle text-start">
                    Rp {{ number_format($prod->price, 0, ',', '.') }}
                </td>
                <td class="align-middle">
                    <div
                        class="d-flex justify-content-center align-items-center gap-3"
                    >
                        <button
                            type="button"
                            class="btn btn-success rounded-4 px-"
                        >
                            Edit
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger rounded-4 px-"
                        >
                            Hapus
                        </button>
                        <button
                            type="button"
                            class="btn rounded-4 px-"
                            style="background-color: #032d64; color: white"
                        >
                            Detail
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach @else
            <tr>
                <td colspan="6">No products found</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-center p-5">
        {{ $product->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
