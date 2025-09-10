<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanUtama extends Model
{
    use HasFactory;

    // Nama tabel di database
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
}
