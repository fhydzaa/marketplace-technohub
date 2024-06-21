@extends('front.layouts.app') @section('content') <br /><br />
<div class="container h-100 mb-3 rounded-4">
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
    <table class="table text-center table-hover">
        <thead class=class="table table-dark" style="background-color: #123159;">
            <tr>
                <th scope="col" class="text-start">No Pesanan</th>
                <th scope="col" class="text-start">Tanggal</th>
                <th scope="col" class="text-start">Total Harga</th>
                <th scope="col" class="text-start">Status</th>
                <th scope="col">Aksi</th>
                <th scope="col">Detail</th>
            </tr>
        </thead>
        <tbody>
            @if($transaction->isNotEmpty()) @foreach ($transaction as $trans)
            <tr class="table-light">
                <td class="align-middle text-start" scope="row">
                    {{ $trans->id_order }}
                </td>
                <td class="align-middle text-start">
                    {{ $trans->created_at }}
                </td>
                <td class="align-middle text-start">
                    Rp {{ number_format($trans->total_price, 0, ',', '.') }}
                </td>
                <td class="align-middle text-start">
                    {{ $trans->status }}
                </td>
                <td class="align-middle">
                    <div
                        class="d-flex justify-content-center align-items-center gap-3"
                    >
                        @if($trans->status == 'pending')
                        <a
                            id="pay-button"
                            data-id="{{ $trans->id }}"
                            class="btn btn-danger rounded-4"
                            href="javascript:void(0);"
                        >
                            Bayar
                        </a>
                        @else
                        <span class="btn btn-secondary rounded-4 disabled">
                            Sudah Bayar
                        </span>
                        @endif
                    </div>
                </td>
                <td>
                    <div>
                        <button
                            class="btn btn-success rounded-4 detail-button"
                            data-id="{{ $trans->id }}"
                        >
                            <i
                                class="bi bi-caret-down-fill"
                                id="caret-{{ $trans->id }}"
                            ></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr
                class="table-light detail-row"
                id="detail-{{ $trans->id }}"
                style="display: none"
            >
                <td colspan="6">
                    <div class="p-3">
                        <table class="table mt-3">
                            <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trans->product as $prod)
                                <tr>
                                    <td>{{ $prod->title }}</td>
                                    <td>{{ $prod->pivot->qty }}</td>
                                    <td>
                                        Rp
                                        {{ number_format($prod->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            @endforeach @else
            <tr>
                <td colspan="6">Tidak ada transaksi</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-center p-5">
        {{ $transaction->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection @section('customJs')
<!-- <script>
    document.querySelectorAll(".detail-button").forEach((button) => {
        button.addEventListener("click", function () {
            const detailRow = document.getElementById(
                "detail-" + this.dataset.id
            );
            if (detailRow.style.display === "none") {
                detailRow.style.display = "table-row";
                this.querySelector(".bi").classList.remove(
                    "bi-caret-down-fill"
                );
                this.querySelector(".bi").classList.add("bi-caret-up-fill");
            } else {
                detailRow.style.display = "none";
                this.querySelector(".bi").classList.remove("bi-caret-up-fill");
                this.querySelector(".bi").classList.add("bi-caret-down-fill");
            }
        });
    });
</script> -->
<script>
    $(document).ready(function () {
        $(".detail-button").click(function () {
            var transId = $(this).data("id");
            $("#detail-" + transId).toggle();
            var caret = $("#caret-" + transId);
            if (caret.hasClass("bi-caret-down-fill")) {
                caret
                    .removeClass("bi-caret-down-fill")
                    .addClass("bi-caret-up-fill");
            } else {
                caret
                    .removeClass("bi-caret-up-fill")
                    .addClass("bi-caret-down-fill");
            }
        });
    });
</script>
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="<?php config('midtrans.clientkey')?>"
></script>
<script type="text/javascript">
    document.getElementById("pay-button").onclick = function () {
        // Kirim permintaan AJAX ke server untuk mendapatkan Snap Token
        let transactionId = this.getAttribute("data-id");
        $.ajax({
            url: "{{ route('front.pay')}}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                transactionId: transactionId,
            },
            success: function (response) {
                if (response.snap_token) {
                    // Mulai pembayaran menggunakan Snap Token yang diperoleh
                    snap.pay(response.snap_token, {
                        // Optional
                        onSuccess: function (result) {
                            /* You may add your own js here, this is just example */
                            window.location.href =
                                "{{ route('transaction.pay', ['transaction' => 'transactionId']) }}".replace(
                                    "transactionId",
                                    transactionId
                                );
                        },
                        // Optional
                        onPending: function (result) {
                            /* You may add your own js here, this is just example */
                            document.getElementById("result-json").innerHTML +=
                                JSON.stringify(result, null, 2);
                        },
                        // Optional
                        onError: function (result) {
                            /* You may add your own js here, this is just example */
                            document.getElementById("result-json").innerHTML +=
                                JSON.stringify(result, null, 2);
                        },
                        onClose: function () {
                            // Handle jika pengguna menutup modal QRIS sebelum pembayaran selesai
                            alert("Anda belum menyelesaikan pembayaran!");
                        },
                    });
                } else {
                    alert("Gagal mendapatkan token transaksi.");
                }
            },
            error: function (error) {
                alert("Terjadi kesalahan saat memproses transaksi.");
                console.error(error);
            },
        });
    };
</script>
@endsection
