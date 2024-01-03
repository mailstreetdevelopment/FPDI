<?php

namespace mailstreetdevelopment\fpdi\unit;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\Fpdi;
use mailstreetdevelopment\fpdi\FpdiTrait;
use mailstreetdevelopment\fpdi\PdfParser\PdfParser;
use mailstreetdevelopment\fpdi\PdfParser\StreamReader;

abstract class FpdiTraitTest extends TestCase
{
    /**
     * @return FpdiTrait
     */
    abstract public function getInstance();

    public function testImportedPageWithoutSettingSourceFile()
    {
        $fpdi = $this->getInstance();
        $this->expectException(\BadMethodCallException::class);
        $fpdi->importPage(1);
    }

    public function testUseImportedPageWithoutSettingSourceFile()
    {
        $fpdi = $this->getInstance();
        $fpdi->AddPage();
        $this->expectException(\InvalidArgumentException::class);
        $fpdi->useImportedPage(1);
    }

    /**
     * Test if $parserParams is forwarded to getPdfParserInstance() method.
     */
    public function testSetSourceFileWithParserParams()
    {
        $parserParams = ['any' => 'thing'];

        $pdf = $this->getMockBuilder(get_class($this->getInstance()))
            ->setMethods(['getPdfParserInstance', 'setMinPdfVersion'])
            ->getMock();

        $fh = fopen(__DIR__ . '/../_files/pdfs/Example-PDF-2.pdf', 'rb+');
        $streamReader = new StreamReader($fh);

        $pdf->expects($this->once())
            ->method('getPdfParserInstance')
            ->with($streamReader, $parserParams)
            ->willReturn(new PdfParser($streamReader));

        $pdf->expects($this->once())
            ->method('setMinPdfVersion');

        $pageCount = $pdf->setSourceFileWithParserParams($streamReader, $parserParams);
        $this->assertSame(10, $pageCount);
    }
}
