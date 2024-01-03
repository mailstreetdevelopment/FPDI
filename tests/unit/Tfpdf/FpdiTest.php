<?php

namespace mailstreetdevelopment\fpdi\unit\Tfpdf;

use mailstreetdevelopment\Fpdi\Tfpdf\Fpdi;
use mailstreetdevelopment\Fpdi\unit\FpdiTraitTest;

class FpdiTest extends FpdiTraitTest
{
    public function getInstance()
    {
        return new Fpdi();
    }
}
