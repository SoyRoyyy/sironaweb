<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahAnggaran extends Model
{
    protected $fillable = ['kegiatan_utama_id', 'sub_kegiatan_id', 'jumlah'];

    public function kegiatanUtama()
    {
        return $this->belongsTo(KegiatanUtama::class);
    }

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }
}
