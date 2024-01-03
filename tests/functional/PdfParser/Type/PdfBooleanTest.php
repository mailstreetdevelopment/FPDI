<?php

namespace mailstreetdevelopment\fpdi\functional\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfBoolean;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfNumeric;

class PdfBooleanTest extends TestCase
{
    public function createProvider()
    {
        $data = [
            ['true', true],
            ['false', true],
            ['3454', true],
            [false, false],
        ];

        return $data;
    }

    /**
     * @param $in
     * @param $expectedResult
     * @dataProvider createProvider
     */
    public function testCreate($in, $expectedResult)
    {
        $result = PdfBoolean::create($in);
        $this->assertInstanceOf(PdfBoolean::class, $result);
        $this->assertSame($expectedResult, $result->value);
    }
}
