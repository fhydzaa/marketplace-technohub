@extends('front.layouts.app')
<section class="hero-element d-flex flex-column gap-3 align-items-center justify-content-evenly py-5" style="margin-top: 70px">
      <div class="d-flex flex-column rounded-4 px-2 align-items-center justify-content-center">
        <h1>Tentang Kami</h1>
      </div>
      <div class="d-flex justify-content-center rounded-4 mx-3 align-items-center">
        <div>
          <img class="rounded-4" src="./img/aboutrafiki.png" width="500px" height="500px" alt="Gambar About">
        </div>
        <p class="text-dark px-4 py-3" style="text-align: justify">
          TechnoHub adalah aplikasi marketplace inovatif yang dirancang khusus untuk jual beli produk game digital. Aplikasi ini menyediakan platform yang user-friendly, di mana pengguna dapat dengan mudah menemukan, membeli, dan menjual
          berbagai produk game digital seperti game software, in-game currency, DLC (Downloadable Content), dan item virtual lainnya. Dengan fitur keamanan canggih, metode pembayaran yang beragam, serta dukungan pelanggan 24/7, TechnoHub
          memastikan transaksi yang aman dan nyaman bagi semua penggunanya. Selain itu, aplikasi ini juga menawarkan sistem rating dan review yang transparan, membantu pembeli membuat keputusan yang lebih bijak serta mendorong penjual untuk
          mempertahankan kualitas produk mereka.
        </p>
      </div>
      <div class="d-flex flex-row flex-wrap gap-5 justify-content-evenly mt-5 px-5 py-5">
        <div class="card rounded-4" style="width: 18rem">
          <img src="./img/instagram.png" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Galih Anggriawan</h5>
            <p class="card-text">Project Owner</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="./img/instagram.png" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Faiq Hidayat Dzakwan</h5>
            <p class="card-text">Back End Developer || Scrum Master</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="./img/instagram.png" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Yackis Pratama Awi</h5>
            <p class="card-text">UI/UX Desainer</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="./img/instagram.png" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Rahman Hakim</h5>
            <p class="card-text">Front End Web Developer</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="./img/instagram.png" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Muhammad Ihya' Ulumuddin</h5>
            <p class="card-text">Back End Web Developer || Bug Hunter</p>
          </div>
        </div>
      </div>
    </section>
@section