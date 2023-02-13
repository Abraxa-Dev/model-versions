<?php

use App\Models\Offer;

test('an offer can have multiple versions with different items', function () {
    $offer = Offer::create([
        'name' => 'Test Offer'
    ]);

    $offerVersion = $offer->newVersion();

    $offerVersion->items()->createMany([
        ['name' => 'Test Item 1'],
        ['name' => 'Test Item 2'],
        ['name' => 'Test Item 3']
    ]);

    expect($offer->latestVersion()->version)->toBe(1);
    expect($offer->items()->count())->toBe(3);

    $offerVersion = $offer->newVersion();
    $offerVersion->items()->create(['name' => 'Test Item 4']);

    expect($offer->latestVersion()->version)->toBe(2);

    $this->assertSame(
        $offerVersion->items()->pluck('id')->toArray(),
        $offer->items()->pluck('offer_items.id')->toArray()
    );
});
