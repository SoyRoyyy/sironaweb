<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanUtama;
use App\Models\SubKegiatan;
use App\Models\JumlahAnggaran;

class LaporanController extends Controller
{
    public function index()
{
    $kegiatanUtamas = KegiatanUtama::with([
        'rekeningUtama',
        'jumlahAnggarans',
        'subKegiatans.subRekening',
        'subKegiatans.jumlahAnggarans'
    ])->get();

    $subKegiatans = SubKegiatan::all(); 
    $subRekenings = \App\Models\SubRekening::all();

    return view('formlaporan', compact('kegiatanUtamas', 'subKegiatans', 'subRekenings'));
}

// public function getSubKegiatan($id)
// {
//     $subKegiatans = \App\Models\SubKegiatan::with('subRekening')
//         ->where('kegiatan_utama_id', $id)
//         ->get();

//     return response()->json($subKegiatans);
// }

public function getSubKegiatan($id)
{
    $subKegiatans = SubKegiatan::with('jumlahAnggarans')->where('kegiatan_utama_id', $id)->get();

    $result = $subKegiatans->map(function($sub){
        return [
            'id' => $sub->id,
            'no_rek' => $sub->no_rek,
            'uraian' => $sub->uraian,
            'jumlah' => $sub->jumlahAnggarans->first()->jumlah ?? 0,
        ];
    });

    return response()->json($result);
}


}
