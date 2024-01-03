<?php

namespace mailstreetdevelopment\fpdi\functional;

use mailstreetdevelopment\fpdi\PdfParser\Type\PdfArray;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfBoolean;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfDictionary;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfName;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfNumeric;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfString;
use mailstreetdevelopment\fpdi\PdfParser\Type\PdfType;

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
