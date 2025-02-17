<?php

namespace mailstreetdevelopment\fpdi\functional\PdfParser\Type;

use PHPUnit\Framework\TestCase;
use mailstreetdevelopment\fpdi\PdfParser\PdfParser;
use mailstreetdevelopment\fpdi\PdfParser\StreamReader;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfBoolean;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfDictionary;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfIndirectObject;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfIndirectObjectReference;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfNull;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfStream;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfToken;

class PdfIndirectObjectTest extends TestCase
{
    public function parseProvider()
    {
        $data = [
            [
                '234',
                '0',
                '1111',
                PdfIndirectObject::create(
                    234,
                    0,
                    PdfNumeric::create(1111)
                )
            ],
            [
                '1',
                '1',
                '<</Length 123>>',
                PdfIndirectObject::create(
                    1,
                    1,
                    PdfDictionary::create([
                        'Length' => PdfNumeric::create(123)
                    ])
                )
            ],
            [
                '1',
                '1',
                "<</Length 5>>\nstream\nHallo\nendstream\nendobj",
                PdfIndirectObject::create(
                    1,
                    1,
                    PdfStream::create(
                        PdfDictionary::create([
                            'Length' => PdfNumeric::create(5)
                        ]),
                        'Hallo'
                    )
                )
            ],
            [
                '2',
                '0',
                "<</Length 10>>\r\nstream\nHallo\nWelt\r\nendstream\nendobj",
                PdfIndirectObject::create(
                    2,
                    0,
                    PdfStream::create(
                        PdfDictionary::create([
                            'Length' => PdfNumeric::create(10)
                        ]),
                        "Hallo\nWelt"
                    )
                )
            ],
            [
                '123',
                '0',
                '<</A 2>>\nendobj\n321 0 1 obj\n444\nendobj',
                PdfIndirectObject::create(
                    123,
                    0,
                    PdfDictionary::create([
                        'A' => PdfNumeric::create(2)
                    ])
                )
            ],
            [
                '1',
                '0',
                "% let's start\n123\nendobj",
                PdfIndirectObject::create(
                    1,
                    0,
                    PdfNumeric::create(123)
                )
            ],
            [
                '1',
                '0',
                "<</Length 4>> % let's start\nstream\nabcd\nendstreamendobj",
                PdfIndirectObject::create(
                    1,
                    0,
                    PdfStream::create(
                        PdfDictionary::create(['Length' => PdfNumeric::create(4)]),
                        'abcd'
                    )
                )
            ]
        ];

        return $data;
    }

    /**
     * @param $in
     * @param $expectedResult
     * @dataProvider parseProvider
     */
    public function testParse($objectNumberToken, $generationNumberToken, $in, $expectedResult)
    {
        $stream = StreamReader::createByString($in);
        $parser = new PdfParser($stream);
        $tokenizer = $parser->getTokenizer();

        $result = PdfIndirectObject::parse($objectNumberToken, $generationNumberToken, $parser, $tokenizer, $stream);
        $this->assertSame($expectedResult->objectNumber, $result->objectNumber);
        $this->assertSame($expectedResult->generationNumber, $result->generationNumber);

        if ($result->value instanceof PdfStream) {
            $this->assertEquals($expectedResult->value->value, $result->value->value);
            $this->assertSame($expectedResult->value->getStream(), $result->value->getStream());

        } else {
            $this->assertEquals($expectedResult, $result);
        }
    }
}
