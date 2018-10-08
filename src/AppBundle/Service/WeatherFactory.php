<?php

namespace AppBundle\Service;

use AppBundle\Weather\Wunderground;

class WeatherFactory
{
    private $weatherService,$em,$apiKey;

    public function __construct($weatherService, $apiKey)
    {
        $this->weatherService = $weatherService;
        $this->apiKey = $apiKey;
    }

    public function __invoke()
    {
        if ($this->weatherService == "wunderground") {
            return new Wunderground($this->apiKey);
        }
        throw new \Exception("Unable to determine weather driver");
    }

}