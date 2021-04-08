<?php

namespace Meema\MeemaApi\Exceptions;

use Exception;

class InvalidFormatException extends Exception
{
    /**
     * Construct exception.
     *
     * @param string $message
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? 'Error on line '.$this->getLine().' in '.$this->getFile()
        .' ID is not a valid integer');
    }
}
