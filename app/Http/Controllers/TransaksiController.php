<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiStoreRequest;
use App\Masjid;
use App\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function create()
    {
        $masjidId = session('masjid_id');
        $data['objek'] = new Transaksi();
        $data['method'] = 'POST';
        $data['route'] = 'transaksi.store';
        $data['namaTombol'] = 'SIMPAN';
        return view('transaksi_form', $data);
    }

    public function store(TransaksiStoreRequest $request)
    {
        $jumlah = str_replace(".", "", $request->jumlah);
        $transaksi = new \App\Transaksi();
        $transaksi->user_id = Auth::user()->id;
        $transaksi->masjid_id = session('masjid')->id;
        $transaksi->keterangan = $request->keterangan;
        $transaksi->jenis = $request->jenis;
        $transaksi->jumlah = $jumlah;
        $transaksi->save();

        $masjid = Masjid::findOrFail(session('masjid')->id);
        $saldoAkhir = 0;
        if ($request->jenis == 'pemasukan') {
            $saldoAkhir = $masjid->saldo + $jumlah;
        } else {
            $saldoAkhir = $masjid->saldo - $jumlah;
        }
        $masjid->saldo = $saldoAkhir;
        $masjid->save();

        flash('data berhasil disimpan');
        return redirect()->route('masjid.show', session('masjid')->id);
    }
}
