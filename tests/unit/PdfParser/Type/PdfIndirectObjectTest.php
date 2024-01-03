<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfArray;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfIndirectObject;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfString;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfTypeException;

class PdfIndirectObjectTest extends TestCase
{
    public function testCreate()
    {
        $value = PdfArray::create([
            PdfNumeric::create(123), PdfString::create('ABCDE')
        ]);
        $result = PdfIndirectObject::create('234', '2', $value);

        $this->assertInstanceOf(PdfIndirectObject::class, $result);

        $this->assertSame($result->value, $value);
        $this->assertSame($result->objectNumber, 234);
        $this->assertSame($result->generationNumber, 2);
    }

    public function testEnsureWithInvlaidArgument1()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfIndirectObject::ensure('test');
    }

    public function testEnsureWithInvlaidArgument2()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfIndirectObject::ensure(PdfName::create('test'));
    }

    public function testEnsure()
    {
        $a = PdfIndirectObject::create(1, 0, PdfNumeric::create(1));
        $b = PdfIndirectObject::ensure($a);
        $this->assertSame($a, $b);
    }
}
