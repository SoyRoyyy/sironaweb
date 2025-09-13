<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanUtama;
use App\Models\SubKegiatan;
use App\Models\RekeningUtama;
use App\Models\SubRekening;
use App\Models\JumlahAnggaran;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelUploadController extends Controller
{
    public function uploadForm()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        $currentKegiatan = null;

        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            if ($rowIndex < 4) continue; 

            $noRek   = trim((string) $sheet->getCell('A'.$rowIndex)->getValue());
            $uraian  = trim((string) $sheet->getCell('B'.$rowIndex)->getValue());
            $jumlah  = $sheet->getCell('C'.$rowIndex)->getCalculatedValue();
            $jumlah  = trim((string) $jumlah);

            if (!$noRek || !$uraian) continue;
            $digits = preg_replace('/\D/', '', $noRek);
            $cell  = $sheet->getCell('B'.$rowIndex);
            $color = strtoupper($cell->getStyle()->getFill()->getStartColor()->getRGB());
            $jumlahClean = preg_replace('/[^\d]/', '', $jumlah);
            if ($color === "FFFF00") {
                $currentKegiatan = KegiatanUtama::create([
                    'uraian' => $uraian,
                ]);

                RekeningUtama::create([
                    'kegiatan_utama_id' => $currentKegiatan->id,
                    'no_rek' => $noRek,
                ]);

                if ($jumlahClean !== '' && is_numeric($jumlahClean)) {
                    JumlahAnggaran::create([
                        'kegiatan_utama_id' => $currentKegiatan->id,
                        'jumlah' => (float) $jumlahClean,
                    ]);
                }
            }

            elseif ($currentKegiatan && strlen($digits) === 12) {
                $subKegiatan = SubKegiatan::create([
                    'kegiatan_utama_id' => $currentKegiatan->id,
                    'uraian' => $uraian,
                    'no_rek' => $noRek,
                ]);

                SubRekening::create([
                    'sub_kegiatan_id' => $subKegiatan->id,
                    'no_rek' => $noRek,
                ]);

                if ($jumlahClean !== '' && is_numeric($jumlahClean)) {
                    JumlahAnggaran::create([
                        'sub_kegiatan_id' => $subKegiatan->id,
                        'jumlah' => (float) $jumlahClean,
                    ]);
                }
            }
        }

        return redirect()->route('formlaporan')->with('success', 'File berhasil diupload dan data disimpan!');

    }

    public function clear()
{
    JumlahAnggaran::truncate();
    SubRekening::truncate();
    SubKegiatan::truncate();
    RekeningUtama::truncate();
    KegiatanUtama::truncate();

    return redirect()->route('formlaporan')->with('success', 'Semua data berhasil dihapus!');
}

}
