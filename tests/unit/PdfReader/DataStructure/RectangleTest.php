<?php

namespace mailstreetdevelopment\fpdi\unit\PdfReader\DataStructure;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\Fpdi\PdfParser\CrossReference\CrossReference;
use mailstreetdevelopment\Fpdi\PdfParser\PdfParser;
use mailstreetdevelopment\Fpdi\PdfParser\StreamReader;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfArray;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfIndirectObject;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfIndirectObjectReference;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\Fpdi\PdfReader\DataStructure\Rectangle;

class RectangleTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [
                [0, 0, 100, 200],
                [0, 0, 100, 200],
                100, 200
            ],
            [
                [100, 200, 0, 0],
                [0, 0, 100, 200],
                100, 200
            ],
            [
                [-100, -200, 0, 0],
                [-100, -200, 0, 0],
                100,
                200
            ],
            [
                [-100, -200, 100, 200],
                [-100, -200, 100, 200],
                200, 400
            ],
            [
                [-50, -50, -200, -200],
                [-200, -200, -50, -50],
                150,
                150
            ],
            [
                [100, 100, -50, -50],
                [-50, -50, 100, 100],
                150,
                150
            ]
        ];
    }

    /**
     * @param $array
     * @param $expectedWidth
     * @param $expectedHeight
     * @dataProvider dataProvider
     */
    public function testGetterAndSetters($array, $expectedArray, $expectedWidth, $expectedHeight)
    {
        list($ax, $ay, $bx, $by) = $array;
        $rect = new Rectangle($ax, $ay, $bx, $by);

        list($llx, $lly, $urx, $ury) = $expectedArray;

        $this->assertSame($expectedWidth, $rect->getWidth());
        $this->assertSame($expectedHeight, $rect->getHeight());
        $this->assertSame($llx, $rect->getLlx());
        $this->assertSame($lly, $rect->getLly());
        $this->assertSame($urx, $rect->getUrx());
        $this->assertSame($ury, $rect->getUry());
        $this->assertSame($expectedArray, $rect->toArray());
    }

    public function testByPdfArray()
    {
        $pdfArray = PdfArray::create([
            PdfNumeric::create(10),
            PdfNumeric::create(20),
            PdfNumeric::create(110),
            PdfNumeric::create(120),
        ]);

        $parser = $this->getMockBuilder(PdfParser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $rect = Rectangle::byPdfArray($pdfArray, $parser);
        $this->assertEquals(10, $rect->getLlx());
        $this->assertEquals(20, $rect->getLly());
        $this->assertEquals(110, $rect->getUrx());
        $this->assertEquals(120, $rect->getUry());
        $this->assertEquals(100, $rect->getWidth());
        $this->assertEquals(100, $rect->getHeight());
    }

    public function testByPdfArrayWithReferences()
    {
        $arrayReference = PdfIndirectObjectReference::create(1, 0);
        $object1 = PdfIndirectObject::create(1, 0, PdfArray::create([
            PdfIndirectObjectReference::create(10, 0),
            PdfIndirectObjectReference::create(20, 0),
            PdfIndirectObjectReference::create(110, 0),
            PdfIndirectObjectReference::create(120, 0),
        ]));

        $object10 = PdfIndirectObject::create(10, 0, PdfNumeric::create(10));
        $object20 = PdfIndirectObject::create(20, 0, PdfNumeric::create(20));
        $object110 = PdfIndirectObject::create(110, 0, PdfNumeric::create(110));
        $object120 = PdfIndirectObject::create(120, 0, PdfNumeric::create(120));

        $xref = $this->getMockBuilder(CrossReference::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIndirectObject'])
            ->getMock();

        $parser = $this->getMockBuilder(PdfParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCrossReference'])
            ->getMock();

        $parser->expects($this->exactly(5))
            ->method('getCrossReference')
            ->willReturn($xref);

        $xref->expects($this->exactly(5))
            ->method('getIndirectObject')
            ->withConsecutive([1], [10], [20], [110], [120])
            ->willReturnOnConsecutiveCalls($object1, $object10, $object20, $object110, $object120);

        $rect = Rectangle::byPdfArray($arrayReference, $parser);
        $this->assertEquals(10, $rect->getLlx());
        $this->assertEquals(20, $rect->getLly());
        $this->assertEquals(110, $rect->getUrx());
        $this->assertEquals(120, $rect->getUry());
        $this->assertEquals(100, $rect->getWidth());
        $this->assertEquals(100, $rect->getHeight());
    }
}
