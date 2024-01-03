<?php

namespace mailstreetdevelopment\fpdi\unit\Tfpdf;

use mailstreetdevelopment\fpdi\Tfpdf\Fpdi;
use mailstreetdevelopment\fpdi\unit\FpdiTraitTest;

class FpdiTest extends FpdiTraitTest
{
    public function getInstance()
    {
        return new Fpdi();
    }
}
