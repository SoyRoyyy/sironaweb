<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanUtama extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_utamas';
    protected $fillable = ['uraian'];

    public function subKegiatans()
    {
        return $this->hasMany(SubKegiatan::class);
    }

    public function rekeningUtamas()
    {
        return $this->hasMany(RekeningUtama::class);
    }

    public function jumlahAnggarans()
    {
        return $this->hasMany(JumlahAnggaran::class, 'kegiatan_utama_id');
    }

    public function rekeningUtama()
    {
        return $this->hasOne(RekeningUtama::class);
    }

}
