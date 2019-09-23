<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Response;

class WeatherController extends Controller
{
    private $client;
    private $baseUri; 

    public function __construct(Client $guzzle)
    {
        $this->client = $guzzle;
        $this->appid = env('OPENWEATHER_APP_ID', '1234');
        $this->baseUri = env('OPENWEATHER_BASE_URI','http://api.openweathermap.org/data/2.5/');       
    }

    /**
     * Fetch weather data by zipcode.
     * https://openweathermap.org/current#zip
     * @param  string  $zip
     * @return Json
     */
    public function getweather($zip)
    {
        try {
            $response = $this->client->get($this->baseUri.'weather',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json'
                    ],
                    'query' =>
                        ['zip' => $zip.',us',
                        'appid' => $this->appid,]
    
                ]);

            if ($response->getStatusCode() == 200) {
                $this->sendData($response)->send();
            } 

        } catch(ClientException $ex) {
            $this->sendErrData($ex)->send();
        }
      
    }

     /**
     * Fetch forecast data by cityname.
     * https://openweathermap.org/current#current#name
     * @param  string  $city
     * @return Json
     */
    public function getforecast($city)
    {
        try {
            $response = $this->client->get($this->baseUri.'forecast',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json'
                    ],
                    'query' =>
                        ['q' => $city,
                        'appid' => $this->appid,]
    
                ]);

            if ($response->getStatusCode() == 200) {
                $this->sendData($response)->send();
            } 

        } catch(ClientException $ex) {
            $this->sendErrData($ex)->send();
       }
    }
    
    // helper functions to process and send payload or exception data
    private function sendData($response) 
    {
        $data = $response->getBody();
        return response($data, 200)
            ->header('Content-Type', 'text/plain');

    }
    
    private function sendErrData($ex)
    {
        $response = $ex->getResponse();
        $statusCode = $response->getStatusCode();
        $responseBodyAsString = $response->getBody()->getContents();
        return response($responseBodyAsString, $statusCode)
                ->header('Content-Type', 'text/plain');

    }


}