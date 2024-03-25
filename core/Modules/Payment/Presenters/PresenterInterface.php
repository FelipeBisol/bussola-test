<?php

namespace Core\Modules\Payment\Presenters;

interface PresenterInterface
{
    public function present(): self;

    public function toArray(): array;
}
