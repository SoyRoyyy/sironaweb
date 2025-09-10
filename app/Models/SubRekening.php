<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRekening extends Model
{
    use HasFactory;

    protected $table = 'sub_rekenings';
    protected $fillable = ['sub_kegiatan_id', 'no_rek'];

    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class);
    }
}
