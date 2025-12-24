<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puasa extends Model
{
    protected $fillable = [
        'user_id',
        'tahun',
        'jumlah_hari',
        'telah_ganti',
        'tarikh_ganti',
        'baki',
    ];

    protected $casts = [
        'tarikh_ganti' => 'date', // atau 'datetime' jika mahu masa
    ];

    public function getBakiAttribute()
    {
        return $this->jumlah_hari - $this->telah_ganti;
    }

    // Auto kira baki
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}