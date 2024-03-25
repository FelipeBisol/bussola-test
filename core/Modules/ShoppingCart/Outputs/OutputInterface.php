<?php

namespace Core\Modules\ShoppingCart\Outputs;

interface OutputInterface
{
    public function getStatus(): OutputStatus;
}
