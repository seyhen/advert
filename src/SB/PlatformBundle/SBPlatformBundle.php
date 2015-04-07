<?php

namespace SB\PlatformBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SBPlatformBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
