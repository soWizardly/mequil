<?php

namespace AppBundle\Weather;

use Unirest;

class Wunderground implements WeatherContract {

    public $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function get(array $locations) {

        foreach ($locations as $location) {

            $response = Unirest\Request::get(
                "http://api.wunderground.com/api/{$this->apiKey}/conditions/q/{$location->getState()}/{$location->getCity()}.json",
                ['Accept' => 'application/json']
            );

            if (empty($response->body->current_observation->temp_c)) {
                throw new \Exception("Invalid Response from ".self::class);
            }

            $locationData[$location->getId()] = $this->format($response);
        }

        return $locationData ?? [];
    }

    public function format($response) {
        return [
            "date"        => new \DateTime,
            "temperature" => $response->body->current_observation->temp_c
        ];
    }

    public function isValidLocation($state,$city) {

        $response = Unirest\Request::get(
            "http://api.wunderground.com/api/{$this->apiKey}/conditions/q/{$state}/{$city}.json",
            ['Accept' => 'application/json']
        );

        if (empty($response->body->current_observation->temp_c)) {
            return false;
        }

        return true;

    }

}