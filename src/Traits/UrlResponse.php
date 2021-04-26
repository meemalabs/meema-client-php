<?php

namespace Meema\MeemaClient\Traits;

use GuzzleHttp\Psr7\Utils;

trait UrlResponse
{
     /**
     * Convert all parameters to string url.
     *
     * @return string
     */
    public function toUrl()
    {
        $queryParams = '';

        $index = 0;

        foreach ($this->args as $key => $param) {
            $separator = '?';

            if ($index) {
                $separator = '&';
            }

            $queryParams .= "{$separator}{$key}={$param}";

            $index++;
        }

        return "https://dev-ops.mee.ma/glenn/1/5/people.jpg{$queryParams}";
    }

    /**
     * Convert all parameters to string url.
     *
     * @return string
     */
    public function toBuffer()
    {
        $path = $this->toUrl();

        return Utils::streamFor($path);
    }
}
