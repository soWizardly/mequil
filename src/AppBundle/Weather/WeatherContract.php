<?php

namespace AppBundle\Weather;

interface WeatherContract {

    public function get(array $locations);
    public function isValidLocation($state,$city);

}