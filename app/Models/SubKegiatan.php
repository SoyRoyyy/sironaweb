<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    use HasFactory;

    protected $table = 'sub_kegiatans';
    protected $fillable = ['kegiatan_utama_id', 'uraian', 'no_rek'];

    public function kegiatanUtama()
    {
        return $this->belongsTo(KegiatanUtama::class);
    }

    public function subRekenings()
    {
        return $this->hasMany(SubRekening::class);
    }

    public function jumlahAnggarans()
    {
        return $this->hasMany(JumlahAnggaran::class, 'sub_kegiatan_id');
    }

    public function subRekening()
    {
        return $this->hasOne(SubRekening::class);
    }



}
