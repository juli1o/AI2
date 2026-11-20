<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Form\Repository\LocationRepository;
use App\Form\Repository\MeasurementRepository;

class WeatherUtil
{

    private LocationRepository $locationRepository;
    private MeasurementRepository $measurementRepository;

    public function __construct(LocationRepository $locationRepository,
                                MeasurementRepository $measurementRepository) {

        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findBy([
            'location' => $location,
        ]);
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if (!$location) {
            return [];
        }
        return $this->getWeatherForLocation($location);
    }

}
