<?php

namespace Meema\MeemaApi\Exceptions;

use Exception;

class InvalidFormatException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @return string
     */
    public function errorMessage(): string
    {
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
        .' ID is not a valid integer';

        return $errorMsg;
    }
}
