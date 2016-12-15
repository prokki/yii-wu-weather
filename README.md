# README

## Installation

### Configuration

config/main.php

  ```php
  // application components
  'components' => array(
  
  [...]
  
    'wuweather' => array(
      "class"  => 'ext.yii-wu-weather.WuWeather',
      "apiKey" => 'YOUR_API_KEY',
      "cache"  => array(
        'lifetime' => 43200,     // in seconds, 43200 sec = 12 hours
        'distance' => 300,       // distance
        'unit'     => 'miles',   // [optional] distance in miles, default is meter 
      ),
  ),
  ```

## Documentation

### Requests

  ```php
  /** @var WuWeather $wuweather */
  $wuweather = Yii::app()->wuweather;
  
  $response = $wuweather->standardRequest()
  ->addFeature("alerts")
  ->addFeature("forecast")
  ->setLanguage("DL")
  ->setLocation(52.5050, 13.4050)
  ->request();
  ```

### Render/Output

  ```php
  $this->getController()->widget('ext.yii-wu-weather.widgets.renderer.WuWeatherStandardForecastRenderer', array(
    'response' => WuWeatherStandardRequestJSONTransformer::Create()->transform($request->getResponse()),
  ));

#### Custom Templates

  ```php
  $this->getController()->widget('ext.yii-wu-weather.widgets.renderer.WuWeatherStandardForecastRenderer', array(
    'response' => WuWeatherStandardRequestJSONTransformer::Create()->transform($request->getResponse()),
    'template' => 'ALIAS_TO_CUSTOM_TEMPLATE',
    'feature'  => 'forecast',                  // optional - to validate requested feature in the response
  ));
  ```