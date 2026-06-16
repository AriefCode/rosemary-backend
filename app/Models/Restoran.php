<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restoran extends Model
{
    protected $table = 'restoran';

    protected $fillable = ['nama', 'alamat', 'kontak'];

    public function orderan(): HasMany
    {
        return $this->hasMany(Orderan::class);
    }
}
