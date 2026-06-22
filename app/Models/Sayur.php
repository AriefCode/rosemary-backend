<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sayur extends Model
{
    protected $table = 'sayur';

    protected $fillable = [
        'nama',
        'satuan',
        'jumlah_persediaan',
        'tanggal_masuk',
        'estimasi_ketahanan',
        'batas_minimum',
    ];

    protected $casts = [
        'jumlah_persediaan' => 'decimal:2',
        'batas_minimum' => 'decimal:2',
        'tanggal_masuk' => 'date',
        'estimasi_ketahanan' => 'integer',
    ];

    public function detailOrderan(): HasMany
    {
        return $this->hasMany(DetailOrderan::class);
    }

    public function getStatusPersediaanAttribute(): string
    {
        if ($this->jumlah_persediaan <= 0) {
            return 'habis';
        }

        if ($this->jumlah_persediaan < $this->batas_minimum) {
            return 'menipis';
        }

        return 'aman';
    }
}
