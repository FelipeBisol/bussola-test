<?php

namespace Core\Modules\Payment\Interfaces;

use Core\Modules\Payment\Outputs\OutputStatus;

interface OutputInterface
{
    public function getStatus(): OutputStatus;
}
