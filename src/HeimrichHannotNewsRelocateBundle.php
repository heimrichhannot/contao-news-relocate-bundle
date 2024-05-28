<?php

namespace HeimrichHannot\NewsRelocateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotNewsRelocateBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}