<?php
declare(strict_types = 1);

namespace Markup\BarcodeBundle\Manager;

interface SharedAccessInterface
{
    public function shareByDefault();

    public function setShareByDefault(bool $default);
}
