<?php

namespace App\Controller;

use App\Form\Repository\LocationRepository;
use App\Form\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country}', name: 'app_weather')]
    public function city(string $city,
                         ?string $country,
                         LocationRepository $locationRepository,
                         MeasurementRepository $measurementRepository): Response
    {
        $location = $locationRepository->findOneByCityAndCountry($city, $country);
        $measurements = $measurementRepository->findByCityAndCountry($city, $country);
        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
