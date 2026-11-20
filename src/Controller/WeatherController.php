<?php

namespace App\Controller;

use App\Form\Repository\LocationRepository;
use App\Form\Repository\MeasurementRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather')]
    public function city(string $city,
                         ?string $country,
                         LocationRepository $locationRepository,
                         WeatherUtil $util): Response
    {
        $location = $locationRepository->findOneByCityAndCountry($city, $country);
        $measurements = $util->getWeatherForLocation($location);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
