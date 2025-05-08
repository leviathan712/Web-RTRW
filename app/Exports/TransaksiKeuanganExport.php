<?php
namespace App\Exports;

use App\Models\TransaksiKeuangan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiKeuanganExport implements FromView
{
    protected $rt;

    public function __construct($rt = null)
    {
        $this->rt = $rt;
    }

    public function view(): View
    {
        $query = TransaksiKeuangan::query()
            ->orderBy('created_at', 'asc');

        if ($this->rt) {
            $query->where('rt', $this->rt)->where('tingkat', 'RT');
        }

        $data = $query->get();

        $kumulatif = 0;

        $data = $data->map(function ($item) use (&$kumulatif) {
            $pemasukan = $item->tipe === 'pemasukan' ? $item->jumlah : 0;
            $pengeluaran = $item->tipe === 'pengeluaran' ? $item->jumlah : 0;

            $kumulatif += $pemasukan - $pengeluaran;

            return [
                'tanggal' => $item->created_at->format('d-m-Y'),
                'judul' => $item->judul,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $kumulatif,
            ];
        });

        return view('exports.transaksi_keuangan', [
            'data' => $data,
        ]);
    }
}
