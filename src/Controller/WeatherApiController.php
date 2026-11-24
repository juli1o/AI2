<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Response;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response {
        $measurements = $weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($twig) {
            $template = $format === 'csv'
                ? 'weather_api/index.csv.twig'
                : 'weather_api/index.json.twig';

            return $this->render($template, [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);
        }

        if ($format === 'csv') {
            $lines = ['city,country,date,celsius,fahrenheit'];
            foreach ($measurements as $m) {
                $lines[] = sprintf(
                    '%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $m->getDate()->format('Y-m-d'),
                    $m->getCelsius(),
                    $m->getFahrenheit()
                );
            }

            return new Response(implode("\n", $lines));
        }

        return $this->json([
            'city' => $city,
            'country' => $country,
            'measurements' => array_map(fn(Measurement $m) => [
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m->getCelsius(),
                'fahrenheit' => $m->getFahrenheit(),
            ], $measurements),
        ]);
    }
}
