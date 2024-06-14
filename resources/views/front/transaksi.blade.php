@extends('front.layouts.app') @section('content')
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
    @if (Session::has('success'))
    <div
        id="successAlert"
        class="alert alert-success alert-dismissible fade show"
        role="alert"
    >
        {{ Session::get('success') }}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
    @endif @if (Session::has('error'))
    <div
        id="errorAlert"
        class="alert alert-danger alert-dismissible fade show"
        role="alert"
    >
        {{ Session::get('error') }}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
    @endif
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" class="text-start">Id</th>
                <th scope="col" class="text-start">Produk</th>
                <th scope="col" class="text-start">Lisensi</th>
                <th scope="col" class="text-start">Harga</th>
                <th scope="col" class="text-start">Tanggal</th>
                <th scope="col" class="text-start">Total Harga</th>
            </tr>
        </thead>
        
    </table>
</div>

@endsection
