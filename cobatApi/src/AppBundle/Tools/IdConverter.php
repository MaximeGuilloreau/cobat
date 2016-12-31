<?php

namespace AppBundle\Tools;

/**
 * Convert json-ld iri to id
 */
class IdConverter
{
    /**
     * @param string $id
     *
     * @return string
     */
    public function removePrefix($id)
    {
        if (($endPrefix = strrpos($id, '/')) === false) {
            return $id;
        }
        return substr($id, $endPrefix + 1);
    }
}
