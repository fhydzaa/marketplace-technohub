@extends('front.layouts.app') @section('content')
@if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Berhasil Menambahkan Profile'
            });
        </script>
        @endif
<section
    class="hero-element d-flex align-items-center justify-content-evenly py-5"
>
    <div class="d-flex">
        <img
            src="{{ asset('front-assets/img/rafiki.png') }}"
            alt="Hero-Image"
        />
    </div>
    <div class="hero-elements d-flex flex-column">
        <h1 class="text-light">
            Berbelanja Lebih Cepat Akses <br />
            Mudah, Belanja Aman.
        </h1>
        <p class="text-light">
            Teknologi revolusioner untuk mempermudah hidup Anda, <br />
            menghadirkan solusi digital terbaik dalam genggaman.
        </p>
        <div class="border-0">
            <a
                href="{{ route('front.product') }}"
                class="btn btn-primary btn-lg rounded-4"
                >Get Product</a
            >
        </div>
    </div>
</section>

<section
    class="d-flex flex-column align-items-center justify-content-evenly section-animation"
    id="animatedSection"
>
    <h2 class="mt-5 text-center">
        Selamat datang di Website Digital Product Terbaik Didunia
    </h2>
    <p class="text-center">Temukan produk game terbaik hanya disini</p>
    <div class="container text-align-center mt-2">
        <div class="d-flex flex-column gap-4">
            <div class="d-flex flex-row justify-content-center flex-wrap gap-4">
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Office
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Game
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Canva
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Word
                </div>
            </div>
            <div class="d-flex flex-row justify-content-center flex-wrap gap-4">
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Powerpoint
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Netflix
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Software
                </div>
                <div
                    class="text-center rounded-4 text-light px-5 py-2"
                    style="background-color: #123159"
                >
                    Data
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="mt-5" width="300px" />
<br />
<hr class="mt-2" width="300px" />

<section class="mt-5 d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div
                class="col-lg-6 d-flex justify-content-center align-items-center"
            >
                <img
                    src="{{ asset('front-assets/img/aboutimg.png') }}"
                    alt="About Image"
                    width="470px"
                    height="413px"
                    class="img-fluid about-img"
                />
            </div>
            <div class="col-lg-6">
                <h2 class="title-about">About Us</h2>
                <p class="deskripsi-about">
                    TechnoHub adalah aplikasi marketplace yang memungkinkan
                    pengguna untuk menjual dan membeli berbagai produk digital
                    game, seperti game software, in-game currency, DLC
                    (Downloadable Content), dan item virtual lainnya. Dengan
                    fitur user-friendly, platform yang canggih, dan dukungan
                    pelanggan 24/7, TechnoHub memberikan pengalaman transaksi
                    yang aman dan nyaman bagi semua pengguna. Selain itu,
                    aplikasi ini juga menawarkan sistem rating dan review yang
                    transparan, membantu pembeli membuat keputusan yang lebih
                    bijak serta mendorong penjual untuk mempertahankan kualitas
                    produk mereka.
                </p>
                <div class="border-0">
                    <a
                        href="{{ route('front.about') }}"
                        id="buttonAbout"
                        class="buttonAbout btn btn-primary rounded-4 px-3 py-2"
                        >Learn More</a
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="mt-5 ms-auto" width="300px" />
<br />
<hr class="mt-2 ms-auto" width="300px" />

<section class="container">
    <h2 class="mt-5" style="color: #123159">Rekomendasi Product</h2>
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
                    style="width: 100%; height: 189px; object-fit: cover"
                />
                @else
                <img
                    src="{{ asset('front-assets/img/product.png') }}"
                    class="card-img-top"
                    alt="Product"
                    style="width: 100%; height: 189px; object-fit: cover"
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
                        style="position: absolute; bottom: 10px; right: 10px"
                        >Detail</a
                    >
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach @endif
</section>

<footer style="background-color: #123159" class="mt-5 d-flex flex-column gap-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="mt-4 d-flex flex-column gap-1">
                    <h2 class="text-warning">Social Media</h2>
                    <div
                        class="d-flex flex-row gap-2 align-items-center justify-content-start"
                    >
                        <a
                            class="fs-5 text-light text-decoration-none"
                            href="#"
                        >
                            <i class="fab fa-facebook"></i>
                            <!-- Memperbaiki kelas ikon menjadi "fab fa-facebook" -->
                            Facebook
                        </a>
                    </div>

                    <div
                        href="#"
                        class="d-flex flex-row gap-2 align-items-center justify-content-start"
                    >
                        <a class="fs-5 text-light text-decoration-none"
                            ><i class="fab fa-instagram"></i> Instagram</a
                        >
                    </div>
                    <div
                        href="#"
                        class="d-flex flex-row gap-2 align-items-center justify-content-start"
                    >
                        <a class="fs-5 text-light text-decoration-none">
                            <i class="fa-brands fa-twitter"></i> Twitter</a
                        >
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="mt-4 d-flex flex-column gap-1 align-items-center">
                    <h2 class="text-warning">Need Help</h2>
                    <div class="d-flex flex-column gap-3 text-light">
                        <p class="">
                            088980034027 (8 am -12 am, monday - saturday)
                        </p>
                        <p>082325980633(1 pm - 6 pm, monday - saturday)</p>
                        <p>technohub2334@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <small class="text-light"
            >Copyright &copy; 2023 Technohub. All Rights Reserved.</small>
    </div>
</footer>
@endsection @section('custuomJs')
<script>
    console.log("hello");
</script>
@endsection
