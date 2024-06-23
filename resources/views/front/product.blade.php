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
                @if(count($product->product_image) > 0)
                    @foreach($product->product_image as $key => $productImage)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img
                                src="{{ asset('uploads/product/large/'.$productImage->image) }}"
                                class="d-block w-100"
                                alt="Product Image"
                                style="width: 700px; height: 500px; object-fit: cover;"
                            />
                        </div>
                    @endforeach 
                @else
                    <div class="carousel-item active">
                        <img
                            src="{{ asset('front-assets/img/product.png') }}"
                            class="d-block w-100"
                            alt="Default Image"
                            style="width: 700px; height: 500px; object-fit: cover;"
                        />
                    </div>
                @endif
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
                        <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        <div class="front-stars" style="width: {{ $ratingPer }}%">
                            <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                            <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                            <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                            <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                            <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="ps-2">({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count.' Reviews' : $product->product_ratings_count.' Reviews'}})</div>
            </div>
            <br><br>
            <h4>Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
            <p>Stok: {{ $product->qty }}</p>

            @if($product->qty)
            <form class="mb-4">
                <p>Kuantitas</p>
                <div class="d-flex flex-row gap-2 align-items-center mt-5">
                    <button
                        type="button"
                        class="btn p-0 border-0 bg-transparent sub d-flex align-items-center"
                        data-id="{{ $product->rowId }}"
                    >
                        <img
                            src="{{ asset('front-assets/img/kurang.png') }}"
                            width="40px"
                            height="40px"
                        />
                    </button>
                    <input
                        type="text"
                        class="px-2 form-control qty-input"
                        style="width: 100px; height: 40px"
                        value="1"
                        readonly
                    />
                    <button
                        type="button"
                        class="btn p-0 border-0 bg-transparent add d-flex align-items-center"
                        data-id="{{ $product->rowId }}"
                    >
                        <img
                            src="{{
                                asset('front-assets/img/tambahh.png')
                            }}"
                            width="40px"
                            height="40px"
                        />
                    </button>
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
                    href="javascript:void(0)"
                    onclick="buynow({{ $product->id }}, {{ $product->price }});"
                        
                        class="btn rounded-4"
                        style="background-color: darkcyan; color: white"
                    >
                        Beli Sekarang
                    </a>
                </div>
            </form>
            @else
            <div class="out-of-stock text-center p-5 my-5" style="border: 2px dashed red; border-radius: 10px; background-color: #f8d7da; color: #721c24;">
                <h1 style="font-size: 2.5rem; font-weight: bold;">HABISS</h1>
                <p style="font-size: 1.2rem;">Maaf, produk ini sedang tidak tersedia.</p>
            </div>
            @endif
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
                                            <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                            <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                            <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                            <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                            <i class="class="fa-duetone fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                            <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                                <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                                <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                                <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
                                                <i class="class="fa-solid fa-star" style="color: #FFD43B;" aria-hidden="true"></i>
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
            </div>
        </div>
    </div>
    </div>
</div>
@endsection @section('customJs')
<script type="text/javascript">
    function addToCart(id) {
        var qtyValue = $('.qty-input').val();
        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: "post",
            data: { id: id,
                qtyValue: qtyValue
             },
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

    function buynow(id, price){
            var qty= $('.qty-input').val();
            let subtotal = price * qty;

        // Kirim permintaan AJAX ke server untuk menyimpan data transaksi
            $.ajax({
                url: "{{ route('front.transaksiProcess') }}", // Sesuaikan URL dengan rute Anda
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    productId: id, // Mengirimkan array produk
                    subtotal: subtotal,
                    price: price,
                    qty:qty

                },
                success: function (response) {
                    if (response.status) {
                        window.location.href = "{{ route('front.transaksi') }}";
                    } else {
                        alert("Gagal memproses transaksi.");
                    }
                },
                error: function (error) {
                    alert("Terjadi kesalahan saat memproses transaksi.");
                    console.error(error);
                },
            });
    }
</script>
<script>
    $(document).ready(function () {
        $(".add").click(function () {
            var qtyElement = $(this).siblings(".qty-input");
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue + 1);

                var rowId = $(this).data("id");
                var newQty = qtyElement.val();
                updateCart(rowId, newQty);
            }
        });

        $(".sub").click(function () {
            var qtyElement = $(this).siblings(".qty-input");
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue - 1);

                var rowId = $(this).data("id");
                var newQty = qtyElement.val();
                updateCart(rowId, newQty);
            }
        });

        function updateCart(rowId, qty) {
            $.ajax({
                url: '{{ route("front.updateCart") }}',
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    rowId: rowId,
                    qty: qty,
                },
                dataType: "json",
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Update cart failed:", error);
                },
            });
        }

        function deleteCart(rowId) {
            $.ajax({
                url: '{{ route("front.deleteCart.cart") }}',
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    rowId: rowId,
                },
                dataType: "json",
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Update cart failed:", error);
                },
            });
        }
    });
</script>
@endsection
