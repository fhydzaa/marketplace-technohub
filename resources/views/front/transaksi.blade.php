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
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" class="text-start">No Pesanan</th>
                <th scope="col" class="text-start">Status</th>
                <th scope="col" class="text-start">Tanggal</th>
                <th scope="col" class="text-start">Total Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($transaction->isNotEmpty()) @foreach ($transaction as $trans)
            <tr>
                <td class="align-middle text-start" scope="row">
                    {{ $trans->id_order }}
                </td>
                <td class="align-middle text-start">{{ $trans->status }}</td>
                <td class="align-middle text-start">
                    {{ $trans->created_at }}
                </td>
                <td class="align-middle text-start">
                    Rp {{ number_format($trans->total_price, 0, ',', '.') }}
                </td>
                <td class="align-middle">
                    <div
                        class="d-flex justify-content-center align-items-center gap-3"
                    >
                        @if($trans->status == 'pending')

                        <a
                            id="pay-button"
                            data-id="{{ $trans->id }}"
                            class="btn btn-danger rounded-4 px-"
                            href="javascript:void(0);"
                        >
                            Bayar
                        </a>
                        <a ref="#" class="btn btn-success rounded-4 px-">
                            Detail
                        </a>
                        @else
                        <a ref="#" class="btn btn-success rounded-4 px-">
                            Detail
                        </a>
                        @endif
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
