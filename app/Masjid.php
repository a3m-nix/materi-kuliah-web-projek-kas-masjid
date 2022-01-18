<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Masjid extends Model
{
    protected $guarded = [];

    public function scopeDataUser($q)
    {
        return $q->where('user_id', Auth::user()->id);
    }

    /**
     * Get all of the transaksi for the Masjid
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getSaldoFormatRupiah()
    {
        return number_format($this->saldo, 0, ",", ".");
    }
}
