<?php
declare(strict_types = 1);

namespace Markup\BarcodeBundle\Manger;

interface SharedAccessInterface
{
    public function shareByDefault();

    public function setShareByDefault(bool $default);
}
