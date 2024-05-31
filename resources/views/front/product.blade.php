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
            <div class="d-flex flex-column gap-2">
                <h4>Deskripsi Produk</h4>
                <p style="text-align: justify">{!! $product->description !!}</p>
            </div>
        </div>

        <div class="col-6 d-flex flex-column gap-2" style="margin-top: 100px">
            <h4>Rp {{ $product->price }}</h4>
            <p>Stok : {{ $product->qty }}</p>
            <form>
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
            <div class="d-flex flex-column gap-3">
                <div class="container d-flex flex-row">
                    <div class="mt-5 w-100">
                        <img
                            src="{{ asset('front-assets/img/product.png') }}"
                            alt="Customer Review"
                        />
                    </div>
                    <div
                        class="mt-5 d-flex flex-column"
                        style="text-align: justify"
                    >
                        <h3>Asep Karbu</h3>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Quis magnam doloribus et architecto maiores
                            eum dolor minima vel pariatur ullam. Ex, vitae ipsum
                            praesentium voluptate esse doloribus voluptates
                            reprehenderit tempore nobis amet perferendis, odit
                            fugiat adipisci! Eligendi in ipsa at quis, provident
                            deleniti officiis nostrum, molestiae amet labore
                            ipsam consectetur?
                        </p>
                    </div>
                </div>
                <div class="container mt-2 d-flex justify-content-end">
                    <a
                        href="#"
                        class="btn"
                        style="background-color: #123159; color: white"
                        >More Review</a
                    >
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
