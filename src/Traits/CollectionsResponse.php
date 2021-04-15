<?php

namespace Meema\MeemaApi\Traits;

trait CollectionsResponse
{
    /**
     * Convert response to collection or array
     *
     * @return \Illuminate\Support\Collection|array
    */
    public function toCollection($response)
    {
        $clientConfig = $this->client->getConfig();

        $toCollection = $clientConfig['to_collection'] ?? false;

        return $toCollection ? collect($response) : $response;
    }
}
