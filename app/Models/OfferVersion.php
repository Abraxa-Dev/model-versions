<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class OfferVersion extends Model
{
    use HasRecursiveRelationships;

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OfferItem::class);
    }

    public function markAsFinal(): void
    {
        $this->is_final = true;
        $this->save();
    }
}
