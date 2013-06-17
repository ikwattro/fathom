<?php

namespace Fathom\Builder\Generator;

use TwigGenerator\Builder\BaseBuilder;

class MapperBuilder extends BaseBuilder
{
    public function getDefaultTemplateName()
    {
        return 'Mapper'.self::TWIG_EXTENSION;
    }

}