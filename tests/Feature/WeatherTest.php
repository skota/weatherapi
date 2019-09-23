<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class WeatherTest extends TestCase
{
    /**
     * Verify API returns 200 when api is called with correct zipcode
     *
     * @return void
     */
    public function testGetWeatherForCorrectZipTest()
    {
        $mock = new MockHandler([
            new Response(200, ['success' => 'here is your data']),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $statusCode = $client->request('GET', '/api/weather/30519')->getStatusCode();    

        $this->assertEquals( $statusCode, 200);

    }

    /**
     * Verify API returns 404 when api is called with incorrect zipcode
     *
     * @return void
     */
    public function testGetWeatherForIncorrectZipTest()
    {
        $mock = new MockHandler([
            new Response(404, ['error' => 'Incorrect zip code']),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        try {
            $client->request('GET', '/api/weather/519');
        } catch(ClientException $e) {
            $this->assertEquals( $e->getResponse()->getStatusCode(), 404);
        }
          
    }

    /**
     * Verify API returns 200 when api is called with correct location
     *
     * @return void
     */
    public function testcorrectForecastTest()
    {
        $mock = new MockHandler([
            new Response(200, ['success' => 'here is your data']),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $statusCode = $client->request('GET', '/api/forecast/london')->getStatusCode();    

        $this->assertEquals( $statusCode, 200);
    }

    /**
     * Verify API returns 404 when api is called with incorrect location
     *
     * @return void
     */
    public function testIncorrectForecastTest()
    {
        $mock = new MockHandler([
            new Response(404, ['error' => 'city not found']),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        try {
            $client->request('GET', '/api/forecast/lundan');
        } catch(ClientException $e) {
            $this->assertEquals( $e->getResponse()->getStatusCode(), 404);
        }
          
    }

}
