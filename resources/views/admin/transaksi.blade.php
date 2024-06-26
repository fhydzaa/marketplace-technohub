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
        </div>
        <div class="py-4">
            <button type="submit" class="btn btn-primary rounded-4 px-4">
                Submit
            </button>
        </div>
    </form>
</div>
<div class="container bg-light h-100 mb-3 rounded-4">
    <br />
    <!-- <div class="py-3">
        <a
            href="{{ route('product.buat') }}"
            class="ms-5 btn btn-primary rounded-4 px-4"
            >Add Product</a
        >
    </div> -->
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
                <th scope="col" class="text-start">User Name</th>
                <th scope="col" class="text-start">Tanggal</th>
                <th scope="col" class="text-start">Total Harga</th>
                <th scope="col" class="text-start">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($transaction->isNotEmpty()) @foreach ($transaction as $trans)
            <tr>
                <td class="align-middle text-start" scope="row">
                    {{ $trans->id_order }}
                </td>
                <td class="align-middle text-start">{{ $trans->user->name}}</td>
                <td class="align-middle text-start">
                    {{ $trans->created_at }}
                </td>
                <td class="align-middle text-start">
                    Rp {{ number_format($trans->total_price, 0, ',', '.') }}
                </td>
                <td class="align-middle text-start">{{ $trans->status }}</td>
                <td>
                    <div>
                        <button
                            class="btn btn-success rounded-4 px- detail-button"
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
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    @if($trans->status == 'success')
                                    <th scope="col">License</th>
                                    @endif  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trans->product as $prod)
                                <tr>
                                    <td>{{ $prod->title }}</td>
                                    <td>
                                        Rp
                                        {{ number_format($prod->price, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $prod->pivot->qty }}</td>
                                    
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
                                    @endif
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
