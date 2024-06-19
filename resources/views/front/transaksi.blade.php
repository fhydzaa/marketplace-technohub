@extends('front.layouts.app') @section('content')
<br><br>
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
                <th scope="col" class="text-start">Status</th>
                <th scope="col" class="text-start">Tanggal</th>
                <th scope="col" class="text-start">Total Harga</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if($transaction->isNotEmpty()) @foreach ($transaction as $trans)
            <tr>
                <th class="align-middle text-start" scope="row">
                    {{ $trans->id }}
                </th>
                <td class="align-middle text-start">{{ $trans->status }}</td>
                <td class="align-middle text-start">{{ $trans->created_at }}</td>
                <td class="align-middle text-start">
                    Rp {{ number_format($trans->total_price, 0, ',', '.') }}
                </td>
                <td class="align-middle">
                    <div
                        class="d-flex justify-content-center align-items-center gap-3"
                    >
                        <a
                            href="#"
                            class="btn btn-danger rounded-4 px-"
                        >
                            Bayar
                        </a>
                        <a
                            ref="#"
                            class="btn btn-success rounded-4 px-"
                        >
                            Detail
                        </a>
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
</div>

@endsection
