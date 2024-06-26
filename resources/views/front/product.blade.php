@extends('front.layouts.app') @section('content')
<div class="container-fluid">
    <div class="container d-flex flex-row gap-5">
        <div class="col-6 d-flex flex-column gap-2 mt-5">
            
            <div
                id="product-carousel"
                class="carousel slide"
                data-bs-ride="carousel"
            >
                <div class="carousel-inner bg-light">
                    @if($product->product_image)
                    @foreach($product->product_image as $key => $productImage)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img
                            class="w-100 h-100"
                            src="{{ asset('uploads/product/large/'.$productImage->image) }}"
                            alt="Image"
                        />
                    </div>
                    @endforeach @endif
                </div>
                <a
                    class="carousel-control-prev"
                    href="#product-carousel"
                    data-bs-slide="prev"
                >
                    <i
                        class="fa fa-2x fa-angle-left text-dark"
                        style="
                            background-color: rgba(255, 255, 255, 0.3);
                            padding: 30px;
                            border-radius: 5px;
                        "
                    ></i>
                </a>
                <a
                    class="carousel-control-next"
                    href="#product-carousel"
                    data-bs-slide="next"
                >
                    <i
                        class="fa fa-2x fa-angle-right text-dark"
                        style="
                            background-color: rgba(255, 255, 255, 0.3);
                            padding: 30px;
                            border-radius: 5px;
                        "
                    ></i>
                </a>
            </div>
            <hr class="mt-5" style="width: 100%" />
            <h4>Deskripsi Produk</h4>
            <div class="d-flex flex-column gap-2 ps-3">
                
                <p style="text-align: justify">{!! $product->description !!}</p>
            </div>
        </div>

        <div class="col-6 d-flex flex-column mt-5">
            <h2>{{ $product->title }}</h2>
            <div class="d-flex align-items-center">
                <h5>{{ $avgRating }}</h5>
                <div class="ps-3 star-rating" title="{{ $avgRatingPer }}%">
                    <div class="back-stars">
                        <h5 class="fa fa-star" aria-hidden="true"></h5>
                        <h5 class="fa fa-star" aria-hidden="true"></h5>
                        <h5 class="fa fa-star" aria-hidden="true"></h5>
                        <h5 class="fa fa-star" aria-hidden="true"></h5>
                        <h5 class="fa fa-star" aria-hidden="true"></h5>
                        <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                            <h5 class="fa fa-star" aria-hidden="true"></h5>
                            <h5 class="fa fa-star" aria-hidden="true"></h5>
                            <h5 class="fa fa-star" aria-hidden="true"></h5>
                            <h5 class="fa fa-star" aria-hidden="true"></h5>
                            <h5 class="fa fa-star" aria-hidden="true"></h5>
                        </div>
                    </div>
                </div>
                <div class="ps-2">({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count.' Reviews' : $product->product_ratings_count.' Reviews'}})</div>
            </div>
            <br><br>
            <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
            <p>Stok: {{ $product->qty }}</p>

        
            <form class="mb-4">
                <p>Kuantitas</p>
                <div class="d-flex flex-row gap-1 align-item-center">
                    <img
                        src="{{ asset('front-assets/img/kurang.png') }}"
                        alt="kurang"
                        width="40px"
                        height="40px"
                        style="cursor: pointer"
                    />
                    <input
                        type="text"
                        id="tambahkurang"
                        name="tambahkurang"
                        class="text-center px-2"
                        style="width: 100px"
                    />
                    <img
                        src="{{ asset('front-assets/img/tambahh.png') }}"
                        width="40px"
                        height="40px"
                        alt="tambah"
                        style="cursor: pointer"
                    />
                </div>
                <div class="container mt-5 d-flex flex-row gap-4">
                    @csrf
                    <a
                        href="javascript:void(0)"
                        onclick="addToCart({{ $product->id }});"
                        class="btn btn-primary rounded-4"
                    >
                        Masukkan Keranjang
                    </a>
                    <a
                        class="btn rounded-4"
                        style="background-color: darkcyan; color: white"
                    >
                        Beli Sekarang
                    </a>
                </div>
            </form>
            <div class="d-flex flex-column gap-3 mb-5">
                <hr class="mt-2" style="width: 100%" />
                <h4>Ulasan Produk</h4>
                <div class="container d-flex flex-row">
                    <div class="d-flex flex-column" style="text-align: justify">
                        <div class="d-flex flex-column gap-2 ps-3" style="max-height: 200px; overflow-y: auto; padding-right: 30px; margin-left: auto;">
                            @if($product->product_ratings->isNotEmpty())
                            @foreach($product->product_ratings as $rating)
                            @php
                                $ratingPer = ($rating->rating*100)/5;
                            @endphp
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="rating-group mb-4">
                                    <span class="author"><strong>{{ $rating->username }}</strong></span>
                                    <div class="star-rating mt-2">
                                        <div class="back-stars">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <p>{{ $rating->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @else
                            <p>Produk belum memiliki ulasan</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="container mt-2 d-flex justify-content-end">
                    <a
                        href="{{ route('front.review', $product->slug) }}"
                        class="btn"
                        style="background-color: #123159; color: white"
                        >Tambah Ulasan</a
                    >
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection @section('customJs')
<script type="text/javascript">
    function addToCart(id) {
        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: "post",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    window.location.href = "{{ route('front.cart') }}";
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                if (xhr.status == 401) {
                    alert("Silahkan login terlebih dahulu");
                    window.location.href = "{{ route('account.login') }}";
                } else {
                    alert("Error - " + xhr.status + ": " + xhr.statusText);
                }
            },
        });
    }
</script>
@endsection
