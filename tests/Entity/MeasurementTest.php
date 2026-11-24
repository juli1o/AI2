<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Measurement;
use PHPUnit\Framework\Attributes\DataProvider;

class MeasurementTest extends TestCase
{
//    public function testGetFahrenheit(): void
//    {
//        $measurement = new Measurement();
//
//        $measurement->setCelsius('0');
//        $this->assertEquals(32, $measurement->getFahrenheit());
//
//        $measurement->setCelsius('-100');
//        $this->assertEquals(-148, $measurement->getFahrenheit());
//
//        $measurement->setCelsius('100');
//        $this->assertEquals(212, $measurement->getFahrenheit());
//    }


    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['20', '68'],
            ['37', '98.6'],
            ['-40', '-40'],
            ['25.5', '77.9'],
            ['-17.5', '0.5'],
            ['12.2', '53.96'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(string $celsius, string $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);

        $this->assertEquals((float) $expectedFahrenheit, $measurement->getFahrenheit());
    }
}
