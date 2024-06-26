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
            class="btn btn-primary rounded-4 px-4"
            >Add Product</a
        >
    </div>
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
                        style="width: 100px; height: 100px; object-fit: cover"
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
                        <a
                            href="{{ route('product.edit', $prod->id) }}"
                            class="btn btn-success rounded-4 px-"
                        >
                            Edit
                        </a>
                        <a
                            onclick="deleteProduct({{ $prod->id }})"
                            class="btn btn-danger rounded-4 px-"
                        >
                            Hapus
                        </a>
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
@endsection @section('customJs')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    var csrfToken = "{{ csrf_token() }}";

    function deleteProduct(id) {
        var url = "{{ route('product.destroy', 'ID') }}";
        var newUrl = url.replace("ID", id);

        if (confirm("Yakin ingin menghapus produk ini?")) {
            $.ajax({
                url: newUrl,
                type: "delete", // Change to POST method
                data: {
                    _token: csrfToken, // Include CSRF token in the request
                },
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        window.location.href = "{{ route('product.page') }}";
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert(
                        "An error occurred while processing your request. Please try again later."
                    );
                },
            });
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Delay closing success alert
    if (document.getElementById('successAlert')) {
        setTimeout(function() {
            $('#successAlert').alert('close');
        }, 2000); // 2000 milliseconds = 2 seconds
    }

    // Delay closing error alert
    if (document.getElementById('errorAlert')) {
        setTimeout(function() {
            $('#errorAlert').alert('close');
        }, 2000); // 2000 milliseconds = 2 seconds
    }
</script>
@endsection
