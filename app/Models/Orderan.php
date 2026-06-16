<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orderan extends Model
{
    protected $table = 'orderan';

    protected $fillable = [
        'restoran_id',
        'karyawan_id',
        'tanggal_orderan',
        'status',
    ];

    protected $casts = [
        'tanggal_orderan' => 'date',
    ];

    public function restoran(): BelongsTo
    {
        return $this->belongsTo(Restoran::class);
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function detailOrderan(): HasMany
    {
        return $this->hasMany(DetailOrderan::class);
    }
}
