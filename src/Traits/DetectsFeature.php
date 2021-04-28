<?php

namespace Meema\MeemaClient\Traits;

use BadMethodCallException;
use Meema\MeemaClient\Exceptions\FeatureNotImplementedException;

trait DetectsFeature
{
    /**
     * Detect if the function called doesn't exist or a missing feature.
     *
     * @return void
     * 
     * @throws BadMethodCallException
     * @throws FeatureNotImplementedException
     */
    public function __call($name, $arguments)
    {
        $data = file_get_contents(dirname(dirname(__DIR__)).'/data/params.json');

        $data = json_decode($data, true);

        $params = array_keys($data['parameters']);

        if (! method_exists($this, $name) && in_array($name, $params)) {
            throw new FeatureNotImplementedException('Feature not yet implemented. Please contact us if this is something you would like to see rather sooner than later.');
        }

        if (! method_exists($this, $name)) {
            throw new BadMethodCallException(sprintf(
                'Call to undefined method %s::%s()', static::class, $name
            ));
        }
    }
}
