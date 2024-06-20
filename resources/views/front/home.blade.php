@extends('front.layouts.app') @section('content')
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
    <h2 class="mt-5 text-center">Selamat datang di Wisata Digital Product</h2>
    <p class="text-center">
        Tempatnya untuk menemukan dan merasakan keajaiban produk digital
        terbaik!
    </p>
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
                    Selamat datang di TechnoHub! Kami adalah komunitas digital
                    yang menyediakan pengalaman berbelanja produk digital
                    terbaik untuk para pecinta teknologi. Dengan kurasi produk
                    yang ketat dan jaringan mitra luas, kami hadir dengan
                    pilihan produk terkini dan berkualitas tinggi, memastikan
                    kenyamanan dan keamanan dalam bertransaksi Lorem ipsum dolor
                    sit amet consectetur, adipisicing elit. Aperiam perspiciatis
                    dolorum excepturi enim labore facilis illum nam ipsa, maxime
                    voluptates totam modi ex, repudiandae sit magni aut laborum
                    odio rerum.
                </p>
                <div class="border-0">
                    <a
                        href="#"
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
                        <a class="fs-5 text-light text-decoration-none"
                            ><img
                                src="{{
                                    asset('front-assets/img/facebook.png')
                                }}"
                                alt="Facebook"
                                width="40px"
                                height="39px"
                                style="margin-right: 10px"
                            />Facebook</a
                        >
                    </div>
                    <div
                        class="d-flex flex-row gap-2 align-items-center justify-content-start"
                    >
                        <a class="fs-5 text-light text-decoration-none"
                            ><img
                                src="{{
                                    asset('front-assets/img/instagram.png')
                                }}"
                                alt="Instagram"
                                width="40px"
                                height="39px"
                                style="margin-right: 10px"
                            />Instagram</a
                        >
                    </div>
                    <div
                        class="d-flex flex-row gap-2 align-items-center justify-content-start"
                    >
                        <a class="fs-5 text-light text-decoration-none"
                            ><img
                                src="{{ asset('front-assets/img/twiter.png') }}"
                                alt="Twitter"
                                width="40px"
                                height="39px"
                                style="margin-right: 10px"
                            />Twitter</a
                        >
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="mt-4 d-flex flex-column gap-1 align-items-center">
                    <h2 class="text-warning">Need Help</h2>
                    <div class="d-flex flex-column gap-3 text-light">
                        <h5 class="">
                            088980034027 (8 am -12 am, monday - saturday)
                        </h5>
                        <h5>082325980633(1 pm - 6 pm, monday - saturday)</h5>
                        <h5>technohub2334@gmail.com</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <small class="text-light"
            >Copyright &copy; 2023 PERLCANDUNIAWI. All Rights Reserved.</small
        >
    </div>
</footer>
@endsection @section('custuomJs')
<script>
    console.log("hello");
</script>
@endsection
