<?php

namespace App\Events;

abstract class BuildersEvent
{
    /**
     * Return the params for a specific event to be triggered on BuildersAPI.
     *
     * @return array
     */
    abstract protected function getData(): array;

    /**
     * Return the complete event data to be sent to BuildersAPI.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->getData();
    }
}
