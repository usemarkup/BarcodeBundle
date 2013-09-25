<?php

namespace Markup\BarcodeBundle\Generator;

/**
* A simple object that wraps the base64_encode function.
*/
class Base64Encoder
{
    /**
     * Encodes data into base64.
     *
     * @param  string $data
     * @return string
     **/
    public function encode($data)
    {
        return base64_encode($data);
    }
}
