<?php

namespace Meema\MeemaClient\Traits;

use Meema\MeemaClient\Exceptions\FeatureNotImplementedException;

trait DetectsFeature
{
    public function __call($name, $arguments)
    {
        if (! method_exists($this, $name)) {
            throw new FeatureNotImplementedException('Feature not yet implemented. Please contact us if this is something you would like to see rather sooner than later.');
        }
    }
}
