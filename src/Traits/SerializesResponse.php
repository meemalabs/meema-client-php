<?php

namespace Meema\MeemaApi\Traits;

trait SerializesResponse
{
    /**
     * Convert the response to array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->content;
    }
}
