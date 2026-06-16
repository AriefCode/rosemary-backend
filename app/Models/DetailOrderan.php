<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailOrderan extends Model
{
    protected $table = 'detail_orderan';

    protected $fillable = [
        'orderan_id',
        'sayur_id',
        'jumlah',
        'satuan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    public function orderan(): BelongsTo
    {
        return $this->belongsTo(Orderan::class);
    }

    public function sayur(): BelongsTo
    {
        return $this->belongsTo(Sayur::class);
    }
}
