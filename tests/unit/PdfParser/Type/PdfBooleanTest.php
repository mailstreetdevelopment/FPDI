<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfBoolean;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfTypeException;

class PdfBooleanTest extends TestCase
{
    public function testCreate()
    {
        $v = PdfBoolean::create(true);
        $this->assertInstanceOf(PdfBoolean::class, $v);
        $this->assertSame(true, $v->value);

        $v = PdfBoolean::create(false);
        $this->assertInstanceOf(PdfBoolean::class, $v);
        $this->assertSame(false, $v->value);
    }

    public function testEnsureWithInvlaidArgument1()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfBoolean::ensure('test');
    }

    public function testEnsureWithInvlaidArgument2()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfBoolean::ensure([PdfName::class, 'test']);
    }

    public function testEnsure()
    {
        $a = PdfBoolean::create(true);
        $b = PdfBoolean::ensure($a);
        $this->assertSame($a, $b);
    }
}