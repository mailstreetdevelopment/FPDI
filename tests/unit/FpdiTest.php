<?php

namespace mailstreetdevelopment\fpdi\unit;

use mailstreetdevelopment\fpdi\Fpdi;

require_once __DIR__ . '/FpdiTraitTest.php';

class FpdiTest extends FpdiTraitTest
{
    public function getInstance()
    {
        return new Fpdi();
    }
}
