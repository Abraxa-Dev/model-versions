<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Offer extends Model
{
    public function versions(): HasMany
    {
        return $this->hasMany(OfferVersion::class);
    }

    public function items(?int $version = null): HasManyThrough
    {
        if ($version === null) {
            $version = $this->finalOrLatestVersion()?->version ?? 1;
        }

        return $this->hasManyThrough(OfferItem::class, OfferVersion::class)
            ->where('offer_versions.version', $version);
    }

    public function latestVersion(): ?OfferVersion
    {
        /* @var OfferVersion */
        return $this->versions()->latest('id')->first();
    }

    public function finalVersion(): ?OfferVersion
    {
        /* @var OfferVersion */
        return $this->versions()->where('is_final', true)->latest()->first();
    }

    public function finalOrLatestVersion(): ?OfferVersion
    {
        return $this->finalVersion() ?? $this->latestVersion();
    }

    public function newVersion(?OfferVersion $fromVersion = null): OfferVersion
    {
        $latestVersion = $this->latestVersion();
        $version = $latestVersion ? $latestVersion->version + 1 : 1;

        $offerVersion = new OfferVersion();
        $offerVersion->offer()->associate($this);
        $offerVersion->parent_id = $fromVersion?->id ?? $latestVersion?->id;
        $offerVersion->version = $version;
        $offerVersion->save();

        if ($latestVersion) {
            foreach ($latestVersion->items as $item) {
                $offerItem = new OfferItem();
                $offerItem->offerVersion()->associate($offerVersion);
                $offerItem->name = $item->name;
                $offerItem->save();
            }
        }

        return $offerVersion;
    }
}
