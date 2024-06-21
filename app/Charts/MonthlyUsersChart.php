<?php

namespace App\Charts;

use App\Models\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $bulan = date('m');
        $hari = date('d');
        for ($i = 1; $i <= $hari; $i++) {
            // Mendapatkan jumlah qty per hari pada bulan ini
            // $trans = DB::table('transaction')
            //     ->join('transaction_details', 'transaction.id', '=', 'transaction_details.transaction_id')
            //     ->where('transaction.status', 'success')
            //     ->whereMonth('transaction.created_at', $bulan)
            //     ->whereDay('transaction.created_at', $i)
            //     ->sum('transaction_details.qty');
            $trans = Transaction::where('status','success')->whereMonth('created_at', $bulan)->whereDay('created_at',$i)->sum('total_price');;
            $data_bulan[] = $i;
            // $data_transaksi[] = number_format($trans, 0, ',', '.');
            $data_transaksi[] = $trans;
        }
        return $this->chart->lineChart()
            ->addData('Total Transaksi', $data_transaksi)
            ->setHeight(250)
            ->setXAxis($data_bulan);
    }
}
