@extends('front.layouts.app') @section('content') @if(count($cartContent) > 0)
<div class="container-fluid">
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

    <div class="row">
        <div class="col-md-8">
            @foreach($cartContent as $item)
            <div
                class="mt-4 container d-flex flex-row product-item"
                style="
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                "
                data-id="{{ $item->id }}"
                data-price="{{ $item->price }}"
                data-qty="{{ $item->qty }}"
            >
                <div class="py-2">
                    @if (!empty($item->options->product_image->image))
                    <img
                        src="{{ asset('uploads/product/small/'.$item->options->product_image->image) }}"
                        class="card-img-top"
                        alt="Product"
                        style="width: 200px; height: 200px; object-fit: cover"
                    />
                    @else
                    <img
                        src="{{ asset('front-assets/img/product.png') }}"
                        class="card-img-top"
                        alt="Product"
                        style="width: 200px; height: 200px; object-fit: cover"
                    />
                    @endif
                </div>
                <div class="d-flex flex-column p-3">
                    <h2 class="mt-3">{{ $item->name }}</h2>
                    <h5>Rp {{ number_format($item->price, 0, ',', '.') }}</h5>
                    <div class="d-flex flex-row gap-2 align-items-center mt-5">
                        <button
                            type="button"
                            class="btn p-0 border-0 bg-transparent sub d-flex align-items-center"
                            data-id="{{ $item->rowId }}"
                        >
                            <img
                                src="{{ asset('front-assets/img/kurang.png') }}"
                                width="20px"
                                height="20px"
                            />
                        </button>
                        <input
                            type="text"
                            class="px-2 form-control qty-input"
                            style="width: 100px; height: 30px"
                            value="{{ $item->qty }}"
                        />
                        <button
                            type="button"
                            class="btn p-0 border-0 bg-transparent add d-flex align-items-center"
                            data-id="{{ $item->rowId }}"
                        >
                            <img
                                src="{{
                                    asset('front-assets/img/tambahh.png')
                                }}"
                                width="20px"
                                height="20px"
                            />
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-3 mt-4">
            <div class="card cart-summery">
                <div class="sub-title">
                    <h2 class="bg-white">Total</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2">
                        <div>Subtotal</div>
                        <div>
                            Rp
                            {{ number_format(Cart::subtotal(0,0,''), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between pb-2">
                        <div>Shipping</div>
                        <div>0</div>
                    </div>
                    <div class="d-flex justify-content-between summery-end">
                        <div>Total</div>
                        <div id="cart-subtotal" data-subtotal="{{ Cart::subtotal(0,0,'') }}">
                            Rp
                            {{ number_format(Cart::subtotal(0,0,''), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="pt-5">
                        <a
                            href="#"
                            id="pay-button"
                            class="btn-dark btn btn-block w-100"
                            >Proceed to Checkout</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container mt-5 d-flex justify-content-center align-items-center">
    <h2>Tidak ada produk di keranjang</h2>
</div>
@endif @endsection @section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="	
    SB-Mid-client-3QtQY0HBxub_GCf3
    "
></script>
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
            if (qtyValue == 1) {
                qtyElement.val(qtyValue - 1);

                var rowId = $(this).data("id");
                var newQty = qtyElement.val();
                deleteCart(rowId);
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

<script>
    // Delay closing success alert
    if (document.getElementById("successAlert")) {
        setTimeout(function () {
            $("#successAlert").alert("close");
        }, 2000); // 2000 milliseconds = 2 seconds
    }

    // Delay closing error alert
    if (document.getElementById("errorAlert")) {
        setTimeout(function () {
            $("#errorAlert").alert("close");
        }, 2000); // 2000 milliseconds = 2 seconds
    }
</script>

<script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
        let products = [];

        // Mengambil semua elemen dengan class 'product-item'
        let productItems = document.querySelectorAll('.product-item');

        // Iterasi melalui setiap elemen untuk mendapatkan ID dan harga produk
        productItems.forEach(function(item) {
            let productId = item.getAttribute('data-id');
            let price = item.getAttribute('data-price');
            let qty = item.getAttribute('data-qty');

            // Tambahkan produk ke array
            products.push({
                id: productId,
                price: price,
                qty: qty
            });
        });

        let subtotalElement = document.getElementById('cart-subtotal');
        let subtotal = subtotalElement.getAttribute('data-subtotal');

        // Kirim permintaan AJAX ke server untuk menyimpan data transaksi
        $.ajax({
            url: "{{ route('front.transaksiProcess') }}", // Sesuaikan URL dengan rute Anda
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                products: products, // Mengirimkan array produk
                subtotal : subtotal
            },
            success: function(response) {
                if (response.status) {
                    window.location.href = "{{ route('front.transaksi') }}";
                } else {
                    alert('Gagal memproses transaksi.');
                }
            },
            error: function(error) {
                alert('Terjadi kesalahan saat memproses transaksi.');
                console.error(error);
            }
        });
    };
</script>
@endsection
