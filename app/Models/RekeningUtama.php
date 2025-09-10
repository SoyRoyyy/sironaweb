<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningUtama extends Model
{
    use HasFactory;

    protected $table = 'rekening_utamas';
    protected $fillable = ['kegiatan_utama_id', 'no_rek'];

    public function kegiatanUtama()
    {
        return $this->belongsTo(KegiatanUtama::class);
    }
}
