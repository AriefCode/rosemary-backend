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
        'batas_minimum',
    ];

    protected $casts = [
        'jumlah_persediaan' => 'integer',
        'batas_minimum' => 'integer',
    ];

    public function detailOrderan(): HasMany
    {
        return $this->hasMany(DetailOrderan::class);
    }

    public function getStatusAttribute(): string
    {
        if ($this->jumlah_persediaan <= 0) {
            return 'habis';
        }

        if ($this->jumlah_persediaan < $this->batas_minimum) {
            return 'rendah';
        }

        return 'aman';
    }
}
