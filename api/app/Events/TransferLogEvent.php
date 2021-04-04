<?php

namespace App\Events;

class TransferLogEvent extends Event
{
    /**
     * TransferLogEvent getter
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * TransferLogEvent setter
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
}
