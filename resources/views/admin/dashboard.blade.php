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
                        <div class="small-box card text-center">
                            <div class="inner">
                                <h1>150</h1>
                                <p>Total Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="small-box card text-center">
                            <div class="inner">
                                <h1>50</h1>
                                <p>Total Customers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="small-box card text-center">
                            <div class="inner">
                                <h1>$1000</h1>
                                <p>Total Sale</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-12 mb-4">
                <div class="small-box card text-center" style="height: 100%">
                    <div class="inner">
                        <h3>Extra Box</h3>
                        <p>Additional Information</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-star"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="container bg-light h-100 mb-3 rounded-4">
            <br />
            <h4>Transaksi terbaru</h4>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th scope="col" class="text-start">Id</th>
                        <th scope="col" class="text-start">User Name</th>
                        <th scope="col" class="text-start">Status</th>
                        <th scope="col" class="text-start">Tanggal</th>
                        <th scope="col" class="text-start">Total Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction->isNotEmpty())
                        @foreach ($transaction as $trans)
                            <tr>
                                <th class="align-middle text-start" scope="row">
                                    {{ $trans->id }}
                                </th>
                                <td class="align-middle text-start">
                                    {{ $trans->user->name }}
                                </td>
                                <td class="align-middle text-start">
                                    {{ $trans->status }}
                                </td>
                                <td class="align-middle text-start">
                                    {{ $trans->created_at }}
                                </td>
                                <td class="align-middle text-start">
                                    Rp {{ number_format($trans->total_price, 0, ',', '.') }}
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="#" class="btn btn-success rounded-4 px-">
                                            Detail
                                        </a>
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
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    console.log("hello");
</script>
@endsection
