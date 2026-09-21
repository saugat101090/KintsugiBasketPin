<?php

namespace KintsugiBasketPin\Providers;

use KintsugiBasketPin\Listeners\BasketPinListener;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemAdd;
use Plenty\Modules\Basket\Events\BasketItem\AfterBasketItemUpdate;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;

class KintsugiBasketPinServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->listen(AfterBasketItemAdd::class, [BasketPinListener::class, 'pin']);
        $dispatcher->listen(AfterBasketItemUpdate::class, [BasketPinListener::class, 'pin']);
    }
}
