<?php

namespace Meema\MeemaClient\Traits;

trait ValidsUuid
{
    /**
     * Check if a given string is a valid UUID
     *
     * @param string $uuid
     *
     * @return boolean
     */
    public function isValidUuid( $uuid ) {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }

        return true;
    }
}
