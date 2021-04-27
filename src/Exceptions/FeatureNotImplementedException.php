<?php

namespace Meema\MeemaClient\Exceptions;

use Exception;

class FeatureNotImplementedException extends Exception
{
    /**
     * Construct exception.
     *
     * @param string $message
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? 'Error on line '.$this->getLine().' in '.$this->getFile()
        .' Feature not yet implemented. Please contact us if this is something you would like to see rather sooner than later.');
    }
}
