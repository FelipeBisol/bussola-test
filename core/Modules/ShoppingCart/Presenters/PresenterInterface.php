<?php

namespace Core\Modules\ShoppingCart\Presenters;

interface PresenterInterface
{
    public function present(): self;

    public function toArray(): array;
}
