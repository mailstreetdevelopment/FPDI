<?php

namespace mailstreetdevelopment\fpdi\functional;

use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfArray;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfBoolean;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfDictionary;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfString;
use mailstreetdevelopment\Fpdi\PdfParser\Type\PdfType;

class PdfTypeDumper
{
    public static function dump(PdfType $value)
    {
        switch (get_class($value)) {
            case PdfName::class:
            case PdfNumeric::class:
            case PdfBoolean::class:
                return $value->value;
            case PdfString::class:
                return PdfString::unescape($value->value);
            case PdfArray::class:
                $result = [];
                foreach ($value->value as $entry) {
                    $result[] = self::dump($entry);
                }
                return $result;
            case PdfDictionary::class:
                $result = [];
                foreach ($value->value as $key => $entry) {
                    $result[$key] = self::dump($entry);
                }
                return $result;
            default:
                throw new \InvalidArgumentException(
                    'Dump of PdfType "' . get_class($value) . '" is not implemented yet.'
                );
        }
    }
}
