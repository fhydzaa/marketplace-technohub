@extends('front.layouts.app')  
<div class="d-flex flex-column gap-3 align-items-center justify-content-evenly py-3">
      
      <div class="d-flex justify-content-center rounded-4 mx-2 align-items-center">
        <div>
          <img class="rounded-4" src="{{ asset('front-assets/img/aboutrafiki1.png') }}" width="500px" height="500px" alt="Gambar About">
        </div>
        <div class="d-flex direction-column flex-row flex-wrap text-dark rounded-4 px-4">
          <div class="d-flex justify-content-start">
            <h1 class="text-start px-4" style="color: #123159">TechnoHub</h1>
          </div>
          <p class="text-dark px-4 py-3" style="text-align: justify" style="background-color: #123159">
            TechnoHub adalah aplikasi marketplace inovatif yang dirancang khusus untuk jual beli produk game digital. Aplikasi ini menyediakan platform yang user-friendly, di mana pengguna dapat dengan mudah menemukan, membeli, dan menjual
            berbagai produk game digital seperti game software, in-game currency, DLC (Downloadable Content), dan item virtual lainnya. Dengan fitur keamanan canggih, metode pembayaran yang beragam, serta dukungan pelanggan 24/7, TechnoHub
            memastikan transaksi yang aman dan nyaman bagi semua penggunanya. Selain itu, aplikasi ini juga menawarkan sistem rating dan review yang transparan, membantu pembeli membuat keputusan yang lebih bijak serta mendorong penjual untuk
            mempertahankan kualitas produk mereka.
          </p>
        </div>
      </div>
      <div class="d-flex flex-row flex-wrap gap-5 justify-content-evenly text-light rounded-4 px-4 py-2" style="background-color: #123159">
          <h2 style="padding: 0; margin: 0;">SCRUM TEAM</h2>
      </div>
      <div class="d-flex flex-row flex-wrap gap-5 justify-content-evenly mt-2 px-5 py-5">
        <div class="card rounded-4" style="width: 18rem">
          <img src="{{ asset('front-assets/img/instagramig.png') }}" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Galih Anggriawan</h5>
            <p class="card-text">Project Owner</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="{{ asset('front-assets/img/instagramig.png') }}" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Faiq Hidayat Dzakwan</h5>
            <p class="card-text">Scrum Master</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="{{ asset('front-assets/img/instagramig.png') }}" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Yackis Pratama Awi</h5>
            <p class="card-text">UI/UX Desainer</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="{{ asset('front-assets/img/instagramig.png') }}" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Rahman Hakim</h5>
            <p class="card-text">Front End Web Developer</p>
          </div>
        </div>
        <div class="card rounded-4" style="width: 18rem">
          <img src="{{ asset('front-assets/img/instagramig.png') }}" class="rounded-4" alt="Gambar About" />
          <div class="card-body">
            <h5 class="fw-bold card-title">Muhammad Ihya' Ulumuddin</h5>
            <p class="card-text">Back End Web Developer</p>
          </div>
        </div>
      </div>
<div>
