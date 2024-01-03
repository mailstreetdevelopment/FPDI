<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfString;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfToken;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfTypeException;

class PdfTokenTest extends TestCase
{
    public function testCreate()
    {
        $v = PdfToken::create("Test");
        $this->assertInstanceOf(PdfToken::class, $v);
        $this->assertSame("Test", $v->value);
    }

    public function testEnsureWithInvlaidArgument1()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfToken::ensure('test');
    }

    public function testEnsureWithInvlaidArgument2()
    {
        $this->expectException(PdfTypeException::class);
        $this->expectExceptionCode(PdfTypeException::INVALID_DATA_TYPE);
        PdfToken::ensure(PdfName::create('test'));
    }

    public function testEnsure()
    {
        $a = PdfToken::create('AToken');
        $b = PdfToken::ensure($a);
        $this->assertSame($a, $b);
    }
}