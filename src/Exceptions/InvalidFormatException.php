<?php

namespace Meema\MeemaClient\Exceptions;

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
        $customMessage = $message ? " {$message}" : ' ID is not a valid integer';

        parent::__construct('Error on line '.$this->getLine().' in '.$this->getFile()
        .$customMessage);
    }
}
