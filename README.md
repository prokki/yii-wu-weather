# README #

This README would normally document whatever steps are necessary to get your application up and running.

### Installation ###

### Configuration ###

```config/main.php```

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

## Documentation ##

### Requests ###

    /** @var WuWeather $wuweather */
    $wuweather = Yii::app()->wuweather;

    $response = $wuweather->standardRequest()
        ->addFeature("alerts")
        ->addFeature("forecast")
        ->setLanguage("DL")
        ->setLocation(52.5050, 13.4050)
        ->request();

### Output ###

    $this->getController()->widget(
        'ext.yii-wu-weather.widgets.renderer.WuWeatherRenderer',
        array(
            'response' => $response,
        )
    );
    
#### Overwrite templates ####
    
    $this->getController()->widget(
        'ext.yii-wu-weather.widgets.renderer.WuWeatherRenderer',
        array(
            'response'         => $response,
            'templateForecast' => 'YOUR_OWN_TAMPLATE',
        )
    );