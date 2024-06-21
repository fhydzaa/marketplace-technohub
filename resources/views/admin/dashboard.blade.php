@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->

<!-- Main content -->
<br />
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-12 mb-4">
                <div class="row gx-3">
                    <div class="col-12 mb-4">
                        <div class="small-box card text-center rounded-4">
                            <div class="inner">
                                <h1>{{ $transaction->where('status', 'success')->count() }}</h1>
                                <p>Total Transaksi Berhasil</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="small-box card text-center rounded-4">
                            <div class="inner">
                                <h1>{{ $transaction->unique('user_id')->count() }}</h1>
                                <p>Total Pembeli</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="small-box card text-center rounded-4">
                            <div class="inner">
                                <h1>Rp {{ number_format($transaction->where('status', 'success')->sum('total_price'), 0, ',', '.') }}</h1>
                                <p>Total Penjualan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-12 mb-4">
                <div class="small-box card mb-3 rounded-4 text-center" style="height: 100%">
                    <div class="inner">
                        <br />
                        <h4>Grafik Penjualan</h4>
                        <div class="p-6 m-20 bg-white">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container bg-light h-100 mb-3 rounded-4 text-center">
            <br />
            <h4>Transaksi terbaru</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" class="text-start">No Pesanan</th>
                        <th scope="col" class="text-start">User Name</th>
                        <th scope="col" class="text-start">Tanggal</th>
                        <th scope="col" class="text-start">Total Harga</th>
                        <th scope="col" class="text-start">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction->isNotEmpty())
                        @foreach ($transaction->take(5) as $trans)
                            <tr>
                                <td class="align-middle text-start" scope="row">{{ $trans->id_order }}</td>
                                <td class="align-middle text-start">{{ $trans->user->name }}</td>
                                <td class="align-middle text-start">{{ $trans->created_at }}</td>
                                <td class="align-middle text-start">Rp {{ number_format($trans->total_price, 0, ',', '.') }}</td>
                                <td class="align-middle text-start">{{ $trans->status }}</td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">Tidak ada transaksi</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endsection
