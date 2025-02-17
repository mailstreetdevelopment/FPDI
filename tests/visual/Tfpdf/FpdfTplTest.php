<?php

namespace mailstreetdevelopment\fpdi\visual\Tfpdf;

use mailstreetdevelopment\fpdi\Tfpdf\FpdfTpl;

class FpdfTplTest extends \setasign\Fpdi\visual\FpdfTplTest
{
    /**
     * Should return __FILE__
     *
     * @return string
     */
    public function getClassFile()
    {
        return __FILE__;
    }

    public function getInstance()
    {
        return new FpdfTpl('P', 'pt');
    }
}
