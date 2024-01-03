<?php

namespace mailstreetdevelopment\fpdi\unit\Tcpdf;

use mailstreetdevelopment\fpdi\Tcpdf\Fpdi;
use mailstreetdevelopment\fpdi\unit\FpdiTraitTest;

class FpdiTest extends FpdiTraitTest
{
    public function getInstance()
    {
        return new Fpdi();
    }
}
