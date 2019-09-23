
## Simple weather API

This is a sample app demonstrating accessing weather and forecast data from weatherapi data. This code includes:

- Simple API routes (without auth).
- Json responses for success or failure.
- phpunit tests to assert success and failure scenarios.


## Installing the app

Clone the code from [github](https://www.github.com/skota)

- run "composer install" to install dependencies.
- mv env.example to .env
- Head over to [https://openweathermap.org/](https://openweathermap.org/) to get your own developer key.
- Add the following settings to .env file
```    
 OPENWEATHER_BASE_URI='http://api.openweathermap.org/data/2.5/'
 OPENWEATHER_APP_ID='your api code'.
``` 

- Update db settings

## running the app
- From "php artisan serve" to launch app.
- To run tests - run command "phpunit"


## Using the API
- Use postman or any other similar tool
- Try to access the following URLs to see responses for weather and forecast data
    - http://127.0.0.1:8000/weather/30519 - to get weather data for zipcode 30519
    - http://127.0.0.1:8000/forecast/london  - to get forecast data by location

## To do
- Add more endpoints
- Add a Vue or React Front end.


## License

This software is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
