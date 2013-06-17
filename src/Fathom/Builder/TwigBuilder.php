<?php

namespace Fathom\Builder;

use TwigGenerator\Builder\BaseBuilder;

class TwigBuilder extends BaseBuilder
{
    public function getDefaultTemplateName()
    {
        return 'Node'.self::TWIG_EXTENSION;
    }

}