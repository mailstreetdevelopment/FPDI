<?php

namespace mailstreetdevelopment\fpdi\unit\Tcpdf;

use mailstreetdevelopment\Fpdi\Tcpdf\Fpdi;
use mailstreetdevelopment\Fpdi\unit\FpdiTraitTest;

class FpdiTest extends FpdiTraitTest
{
    public function getInstance()
    {
        return new Fpdi();
    }
}
