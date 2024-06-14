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
                class="mt-4 container d-flex flex-row"
                style="
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                "
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
                        <div>
                            Rp
                            {{ number_format(Cart::subtotal(0,0,''), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="pt-5">
                        <a href="#" class="btn-dark btn btn-block w-100"
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
@endsection
