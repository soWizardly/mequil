<?php

namespace AppBundle\Command;

use AppBundle\Entity\Location;
use AppBundle\Entity\LocationData;
use AppBundle\Service\WeatherFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;

class GetWeatherCommand extends Command {

    private $weatherApi,$em;

    public function __construct(WeatherFactory $weatherFactory, EntityManager $em)
    {
        $this->weatherApi = $weatherFactory();
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('weather:get')->setDescription("Gets weather")->setHelp("Gets weather");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locations = $this->em->getRepository(Location::class)->findAll();
        if (empty($locations)) {
            throw new \Exception("No locations available");
        }

        $results = $this->weatherApi->get($locations);
        if (empty($results)) {
            throw new \Exception("No weather results from locations");
        }

        foreach ($results as $locationId => $data) {
            $locationData = new LocationData;
            $locationData->setLocationId($locationId);
            $locationData->setDate($data["date"]);
            $locationData->setTemperature($data["temp"]);
            $this->em->persist($locationData);
        }

        $this->em->flush();

        $output->writeln("data added for ".count($results)." records");
    }

}