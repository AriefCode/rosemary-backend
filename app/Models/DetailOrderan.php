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
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
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
