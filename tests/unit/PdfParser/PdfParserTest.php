<?php

namespace mailstreetdevelopment\fpdi\unit\PdfParser;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\CrossReference\CrossReference;
use mailstreetdevelopment\fpdi\PdfParser\PdfParser;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfDictionary;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfIndirectObject;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfIndirectObjectReference;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;

class PdfParserTest extends TestCase
{
    public function testGetIndirectObjectCache()
    {
        $xref = $this->getMockBuilder(CrossReference::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIndirectObject'])
            ->getMock();

        $parser = $this->getMockBuilder(PdfParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCrossReference'])
            ->getMock();

        $parser->expects($this->exactly(2))
            ->method('getCrossReference')
            ->willReturn($xref);

        $expectedResult = PdfIndirectObject::create(1, 0, PdfName::create('Cached'));
        $xref->expects($this->exactly(2))
            ->method('getIndirectObject')
            ->with(1)
            ->willReturn($expectedResult);

        $this->assertSame($expectedResult, $parser->getIndirectObject(1));
        $this->assertSame($expectedResult, $parser->getIndirectObject(1, true));
        $this->assertSame($expectedResult, $parser->getIndirectObject(1, true));
    }

    public function testGetCatalog()
    {
        $xref = $this->getMockBuilder(CrossReference::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTrailer', 'getIndirectObject'])
            ->getMock();


        $xref->expects($this->once())
            ->method('getTrailer')
            ->willReturn(PdfDictionary::create([
                'Info' => PdfIndirectObjectReference::create(2, 0),
                'Root' => PdfIndirectObjectReference::create(1, 0)
            ]));

        $catalog = PdfDictionary::create([
            'Type' => PdfName::create('Catalog'),
            'Pages' => PdfIndirectObjectReference::create(3, 0)
        ]);

        $xref->expects($this->once())
            ->method('getIndirectObject')
            ->willReturn($catalog);

        $parser = $this->getMockBuilder(PdfParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCrossReference'])
            ->getMock();

        $parser->expects($this->exactly(2))
            ->method('getCrossReference')
            ->willReturn($xref);

        $this->assertSame($catalog, $parser->getCatalog());
    }
}