<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Location;
use AppBundle\Entity\LocationData;
use AppBundle\Service\WeatherFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationsController extends Controller
{

    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction() {
        return $this->render('default/dashboard.html.twig', [
            'locations' => $this->getDoctrine()->getRepository(Location::class)->findAllComputed()
        ]);
    }

    /**
     * @Route("/locations/{locationId}", name="location")
     */
    public function showAction($locationId) {
        return $this->render('default/show.html.twig', [
            'location' => $this->getDoctrine()->getRepository(Location::class)->findOneComputed($locationId),
            'data' => $this->getDoctrine()->getRepository(LocationData::class)->findByLocationIdComputed($locationId)
        ]);
    }

    /**
     * @Route("/locations/", name="createLocation")
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager, WeatherFactory $weatherFactory) {

        $city  = str_replace(" ", "_", ucwords(strtolower($request->request->get('city'))));
        $state = ucwords(strtolower($request->request->get('state')));

        if (strlen($state)>2) {
            throw new \Exception("Must put a states 2 character abbreviation");
        }

        $weatherApi = $weatherFactory();
        if (!$weatherApi->isValidLocation($state,$city)) {
            throw new \Exception("Invalid city/state input");
        }

        $locationData = new Location;
        $locationData->setCity($city);
        $locationData->setState($state);
        $entityManager->persist($locationData);
        $entityManager->flush();

        return $this->redirectToRoute('dashboard');
    }
}
