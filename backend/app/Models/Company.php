<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    public function franchises(): HasMany
    {
        return $this->hasMany(Franchise::class);
    }
}
