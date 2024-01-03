<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfHexString;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfTypeException;

class PdfHexStringTest extends TestCase
{
    public function testCreate()
    {
        $v = PdfHexString::create('F6F6');
        $this->assertInstanceOf(PdfHexString::class, $v);
        $this->assertSame('F6F6', $v->value);
    }

    public function testEnsureWithInvlaidArgument1()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfHexString::ensure('test');
    }

    public function testEnsureWithInvlaidArgument2()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfHexString::ensure(PdfName::create('test'));
    }

    public function testEnsure()
    {
        $a = PdfHexString::create('F6F6F6');
        $b = PdfHexString::ensure($a);
        $this->assertSame($a, $b);
    }
}
