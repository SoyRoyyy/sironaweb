<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanUtama;
use App\Models\SubKegiatan;
use App\Models\RekeningUtama;
use App\Models\SubRekening;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelUploadController extends Controller
{
    public function uploadForm()
    {
        return view('excel.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $currentKegiatan = null;

        foreach ($rows as $index => $row) {
            // Lewati header (misalnya 3 baris pertama di Excel)
            if ($index < 4) continue;

            $noRek  = isset($row['A']) ? trim($row['A']) : null;
            $uraian = isset($row['B']) ? trim($row['B']) : null;

            if (!$noRek || !$uraian) continue;

            // ========== Kegiatan Utama ==========
            if ($this->isKegiatanUtama($noRek)) {
                // Simpan kegiatan utama
                $currentKegiatan = KegiatanUtama::create([
                    'uraian' => $uraian,
                ]);

                // Rekening utama
                RekeningUtama::create([
                    'kegiatan_utama_id' => $currentKegiatan->id,
                    'no_rek' => $noRek,
                ]);
            } 
            // ========== Sub Kegiatan ==========
            else {
                if ($currentKegiatan) {
                    // Simpan sub kegiatan
                    $subKegiatan = SubKegiatan::create([
                        'kegiatan_utama_id' => $currentKegiatan->id,
                        'uraian' => $uraian,
                        'no_rek' => $noRek,
                    ]);

                    // Simpan sub rekening
                    SubRekening::create([
                        'sub_kegiatan_id' => $subKegiatan->id,
                        'no_rek' => $noRek,
                    ]);
                }
            }
        }

        return back()->with('success', 'File berhasil diupload dan data disimpan!');
    }

    /**
     * Tentukan apakah baris adalah kegiatan utama
     * Logika: kalau titik <= 1 → kegiatan utama
     */
    private function isKegiatanUtama($noRek)
    {
        return substr_count($noRek, '.') <= 1;
    }

    /**
     * Tentukan apakah sub kegiatan
     * Logika: titik >= 2 → sub kegiatan
     */
    private function is12Digit($noRek)
    {
        return substr_count($noRek, '.') >= 2;
    }
}
