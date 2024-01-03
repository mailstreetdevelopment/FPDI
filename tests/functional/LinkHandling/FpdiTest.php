<?php

namespace mailstreetdevelopment\fpdi\functional\LinkHandling;

use setasign\Fpdi\Fpdi;

class FpdiTest extends \setasign\Fpdi\functional\LinkHandling\AbstractTest
{
    protected function getInstance($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        return new Fpdi($orientation, $unit, $size);
    }
}
