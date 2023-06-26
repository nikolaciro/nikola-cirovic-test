<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Franchise extends Model
{
    protected $fillable = [
        'placeId',
        'address',
        'phone',
        'rating',
        'reviews',
        'reviewsPerMonth',
        'score'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function setPlaceIdAttribute($value): void
    {
        $this->attributes['place_id'] = $value;
    }

    public function getPlaceIdAttribute(): string
    {
        return $this->attributes['place_id'];
    }

    public function setReviewsPerMonthAttribute($value): void
    {
        $this->attributes['reviews_per_month'] = $value;
    }

    public function getReviewsPerMonthAttribute(): string
    {
        return $this->attributes['reviews_per_month'];
    }
}
