<?php

class WuWeatherStandardResponseModel
{
	/**
	 * @var WuWeatherStandardResponseResponseModel
	 */
	public $response = null;

	/**
	 * @var WuWeatherStandardResponseForecastModel
	 */
	public $forecast = null;

	/**
	 * WuWeatherStandardResponseModel constructor.
	 *
	 * @param stdClass $response
	 */
	public function __construct($response)
	{

		$this->response = new WuWeatherStandardResponseResponseModel($response->response);

		$this->forecast = new WuWeatherStandardResponseForecastModel($response->forecast);
	}
}

class WuWeatherStandardResponseResponseModel
{
	/**
	 * @var string
	 */
	public $version = '';

	/**
	 * @var string
	 */
	public $termsofService = '';

	/**
	 * @var WuWeatherStandardResponseResponseFeatureModel[]
	 */
	public $features = array();

	/**
	 * WuWeatherStandardResponseResponseModel constructor.
	 *
	 * @param stdClass $response
	 */
	public function __construct($response)
	{
		$this->version = $response->version;

		$this->termsofService = $response->termsofService;

		$this->features = new WuWeatherStandardResponseResponseFeatureModel($response->features);
	}
}

class WuWeatherStandardResponseResponseFeatureModel
{
	/**
	 * @var bool
	 */
	public $forecast = false;

	/**
	 * @var bool
	 */
	public $alerts = false;

	/**
	 * WuWeatherStandardResponseResponseFeatureModel constructor.
	 *
	 * @param stdClass $feature
	 */
	public function __construct($feature)
	{
		foreach( get_object_vars($feature) as $_key => $value )
		{
			if( !property_exists($this, $_key) )
			{
				throw new InvalidArgumentException(sprintf('invalid feature %s in response', $_key));
			}

			$this->{$_key} = (bool) $value;
		}
	}
}