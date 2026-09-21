<?php

namespace KintsugiBasketPin\Listeners;

use Plenty\Modules\Basket\Contracts\BasketItemRepositoryContract;
use Plenty\Modules\Basket\Events\BasketItem\BasketItemEvent;
use Plenty\Modules\Basket\Models\BasketItem;

class BasketPinListener
{
    public const VAT_FIELD_D = 3;

    public function pin(BasketItemEvent $event)
    {
        $line = $event->getBasketItem();
        if (!$line instanceof BasketItem || (int) $line->variationId <= 0) {
            return;
        }
        if ((int) $line->givenVatId === self::VAT_FIELD_D && $line->useGivenPrice === true) {
            return;
        }

        $items = pluginApp(BasketItemRepositoryContract::class);
        $items->updateBasketItem(
            (int) $line->id,
            [
                'variationId' => (int) $line->variationId,
                'quantity' => $line->quantity,
                'givenVatId' => self::VAT_FIELD_D,
                'givenPrice' => $line->price,
                'useGivenPrice' => true,
            ],
            true
        );
    }
}
