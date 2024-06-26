@extends('front.layouts.app')
@section('content')

<br /><br />
<div class="container h-100 mb-3 rounded-4">
    @if (Session::has('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (Session::has('error'))
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <table class="table text-center table-hover">
        <thead  style="background-color: #123159">
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
            @if($transaction->isNotEmpty())
            @foreach ($transaction as $trans)
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
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        @if($trans->status == 'pending')
                        <a class="btn btn-danger rounded-4 pay-button" data-id="{{ $trans->id }}" href="javascript:void(0);">Bayar</a>
                        @else
                        <span class="btn btn-secondary rounded-4 disabled">Sudah Bayar</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div>
                        <button class="btn btn-success rounded-4 detail-button" data-id="{{ $trans->id }}">
                            <i class="bi bi-caret-down-fill" id="caret-{{ $trans->id }}"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="table-light detail-row" id="detail-{{ $trans->id }}" style="display: none">
                <td colspan="6">
                    <div class="p-3">
                        <table class="table mt-3">
                            <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    @if($trans->status == 'success')
                                    <th scope="col">License</th>
                                    <th scope="col">Ulasan</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trans->product as $prod)
                                <tr>
                                    <td class="text-center align-middle">
                                        {{ $prod->title }}
                                    </td>
                                    <td class="text-center align-middle">
                                        Rp {{ number_format($prod->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $prod->pivot->qty }}
                                    </td>
                                    @if($trans->status == 'success')
                                    <td class="text-center align-middle">
                                        @if($transaction_details->isNotEmpty())
                                        @foreach($transaction_details as $trans_det)
                                        @if($trans_det->id == $prod->pivot->id)
                                        @foreach($trans_det->transactionLicense as $trans_li)
                                        {{ $trans_li->license }}<br />
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @else
                                        No license available
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('front.review', $prod->slug) }}" class="btn btn-primary btn-review rounded-4" style="background-color: #123159; color: white;">
                                            <i class="fa-solid fa-pen"></i> Beri Ulasan
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
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
    data-client-key="{{ config('midtrans.clientkey') }}"
></script>
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

        $(".pay-button").click(function () {
            let transactionId = $(this).data("id");
            $.ajax({
                url: "{{ route('front.pay') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    transactionId: transactionId,
                },
                success: function (response) {
                    if (response.snap_token) {
                        checkTransactionStatus(response.snap_token, transactionId);
                        snap.pay(response.snap_token, {
                            onSuccess: function (result) {
                                window.location.href = "{{ route('transaction.pay', ['transaction' => 'transactionId']) }}".replace("transactionId", transactionId);
                            },
                            onPending: function (result) {
                                document.getElementById(
                                    "result-json"
                                ).innerHTML += JSON.stringify(result, null, 2);
                            },
                            onError: function (result) {
                                document.getElementById(
                                    "result-json"
                                ).innerHTML += JSON.stringify(result, null, 2);
                            },
                            onClose: function () {
                                
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
        });

        function checkTransactionStatus(snapToken, transactionId) {
            $.ajax({
                url:  "{{ route('transaction.cek') }}",
                method: 'GET',
                data: {
                    snap_token: snapToken,
                },
                success: function(data) {
                    if (data.transaction_status === 'settlement') {
                        window.location.href = "{{ route('transaction.pay', ['transaction' => 'transactionId']) }}".replace("transactionId", transactionId);
                    } else {
                        $('#status-message').text(`Transaction Status: ${data.transaction_status}`);
                        resolve();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching transaction status:', errorThrown);
                    $('#status-message').text('Error fetching transaction status');
                }
            });
    }
    });
</script>
@endsection
