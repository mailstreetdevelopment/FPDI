<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2023 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace mailstreetdevelopment\fpdi\PdfParser\Filter;

/**
 * Exception for LZW filter class
 */
class LzwException extends FilterException
{
    /**
     * @var integer
     */
    const LZW_FLAVOUR_NOT_SUPPORTED = 0x0501;
}
