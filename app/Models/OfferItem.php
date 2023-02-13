<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OfferItem extends Model
{
    // assign uid on model create
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->uid = Str::uuid();
        });
    }

    public function offerVersion(): BelongsTo
    {
        return $this->belongsTo(OfferVersion::class);
    }
}
