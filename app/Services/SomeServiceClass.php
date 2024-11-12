<?php

namespace App\Services;

class SomeServiceClass
{
    /**
     * Example method to demonstrate service execution
     *
     * @param array $parameters
     * @return string
     */
    public function processTask($parameters = [])
    {
        // Add your service logic here
        sleep(5);
        return "Service task processed with parameters: " . json_encode($parameters);
    }
}
