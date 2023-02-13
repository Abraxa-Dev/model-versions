<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferItem extends Model
{
    public function offerVersion(): BelongsTo
    {
        return $this->belongsTo(OfferVersion::class);
    }
}
