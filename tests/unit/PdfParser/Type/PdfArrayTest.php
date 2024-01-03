<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfArray;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfString;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfTypeException;

class PdfArrayTest extends TestCase
{
    public function testCreate()
    {
        $values = [
            'A' => PdfNumeric::create(123),
            'B' => PdfString::create('Test')
        ];

        $dict = PdfArray::create($values);
        $this->assertInstanceOf(PdfArray::class, $dict);

        $this->assertSame($values, $dict->value);
    }

    public function testEnsureWithInvlaidArgument1()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfArray::ensure('test');
    }

    public function testEnsureWithInvlaidArgument2()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfArray::ensure(PdfName::create('test'));
    }

    public function testEnsure()
    {
        $a = PdfArray::create([]);
        $b = PdfArray::ensure($a);
        $this->assertSame($a, $b);
    }

    public function testEnsureWithCount()
    {
        $a = PdfArray::create([PdfNumeric::create(1)]);
        $b = PdfArray::ensure($a, 1);
        $this->assertSame($a, $b);
    }

    public function testEnsureWithCountWithInvalidArgument()
    {
        $a = PdfArray::create([PdfNumeric::create(1)]);
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_SIZE);
        PdfArray::ensure($a, 2);
    }
}
