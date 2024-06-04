@extends('front.layouts.app') @section('content')
<div class="container-fluid">
    <form
        class="mt-4 d-flex flex-column justify-content-center"
        action="{{ route('front.product') }}"
        method="get"
    >
        <div class="container d-flex mb-5 gap-4 justify-content-center">
            <input
                value="{{ Request::get('search') }}"
                name="search"
                id="search"
                class="rounded-4 px-4"
                type="text"
                placeholder="Cari Produk Berdasarkan Nama ....."
            />
            <button type="submit" class="btn btn-primary rounded-4 px-4">
                Search
            </button>
        </div>
    </form>
    <section class="container">
        <div class="container mb-4">
            @if ($product->isNotEmpty()) @foreach ($product->chunk(3) as $chunk)
            <div class="row mb-4">
                @foreach ($chunk as $prod) @php $productImage =
                $prod->product_image->first(); @endphp
                <div class="col-md-4 d-flex justify-content-center">
                    <div class="card mt-2" style="width: 230px; height: 350px">
                        @if (!empty($productImage->image))
                        <img
                            src="{{ asset('uploads/product/small/'.$productImage->image) }}"
                            class="card-img-top"
                            alt="Product"
                            style="
                                width: 100%;
                                height: 189px;
                                object-fit: cover;
                            "
                        />
                        @else
                        <img
                            src="{{ asset('front-assets/img/product.png') }}"
                            class="card-img-top"
                            alt="Product"
                            style="
                                width: 100%;
                                height: 189px;
                                object-fit: cover;
                            "
                        />
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">
                                {{ $prod->title }}
                            </h5>
                            <p class="card-text">
                                Rp
                                {{ number_format($prod->price, 0, ',', '.') }}
                            </p>
                            <a
                                href="{{ route('front.detilProduct', $prod->slug) }}"
                                class="btn btn-primary"
                                style="
                                    position: absolute;
                                    bottom: 10px;
                                    right: 10px;
                                "
                                >Detail</a
                            >
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach @else
            <div
                class="container d-flex flex-column align-items-center mt-5"
                style="max-width: 400px"
            >
                <div style="background-color: #ffffff">
                    <img
                        src="{{ asset('front-assets/img/not-found.png') }}"
                        class="img-fluid"
                        alt="Product not found"
                        width="174px"
                        height="189px"
                    />
                </div>
                <br />
                <div
                    class="border rounded p-3"
                    style="background-color: #ffffff"
                >
                    <h4 style="color: #123159">No product found</h4>
                    <p>
                        Try adjusting your search or filter to find what you are
                        looking for.
                    </p>
                </div>
            </div>
            @endif
        </div>

        <div class="pagination-container d-flex justify-content-center p-5">
            {{ $product->links('pagination::bootstrap-4') }}
        </div>
    </section>
</div>
@endsection
