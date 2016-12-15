<?php

class WuWeatherStandardResponseForecastModel
{
	/**
	 * @var WuWeatherStandardResponseForecastTxtModel
	 */
	public $txt_forecast = null;

	/**
	 * @var WuWeatherStandardResponseSimpleforecastModel
	 */
	public $simpleforecast = null;

	/**
	 * WuWeatherStandardResponseForecastModel constructor.
	 *
	 * @param stdClass $forecast
	 */
	public function __construct($forecast)
	{
		$this->txt_forecast = new WuWeatherStandardResponseForecastTxtModel($forecast->txt_forecast);

		$this->simpleforecast = new WuWeatherStandardResponseSimpleforecastModel($forecast->simpleforecast);
	}
}


class WuWeatherStandardResponseForecastTxtModel
{
	/**
	 * @var DateTime
	 */
	public $date = null;

	/**
	 * @var WuWeatherStandardResponseForecastDayModel[]
	 */
	public $forecastday = array();

	/**
	 * WuWeatherStandardResponseForecastModel constructor.
	 *
	 * @param stdClass $txt_forecast
	 */
	public function __construct($txt_forecast)
	{
		$this->date = new DateTime($txt_forecast->date);

		$this->forecastday = array_map(function ($day) { return new WuWeatherStandardResponseForecastDayModel($day); }, $txt_forecast->forecastday);
	}
}

class WuWeatherStandardResponseForecastDayModel
{
	/**
	 * @var int
	 */
	public $period = 0;

	/**
	 * @var string
	 */
	public $icon = '';

	/**
	 * @var string
	 */
	public $icon_url = '';

	/**
	 * @var string
	 */
	public $title = '';

	/**
	 * @var string
	 */
	public $fcttext = '';

	/**
	 * @var string
	 */
	public $fcttext_metric = '';

	/**
	 * @var int
	 */
	public $pop = 0;

	/**
	 * WuWeatherStandardResponseForecastDayModel constructor.
	 *
	 * @param stdClass $forecastday
	 */
	public function __construct($forecastday)
	{

		foreach( get_object_vars($forecastday) as $_key => $value )
		{
			if( !property_exists($this, $_key) )
			{
				throw new InvalidArgumentException(sprintf('invalid property %s in forecastday', $_key));
			}

			$this->{$_key} = $value;
		}

		$this->pop = (int) $this->pop;

	}
}

class WuWeatherStandardResponseSimpleforecastModel
{

	/**
	 * @var WuWeatherStandardResponseSimpleforecastDayModel[]
	 */
	public $forecastday = array();

	/**
	 * WuWeatherStandardResponseSimpleforecastModel constructor.
	 *
	 * @param stdClass $simpleforecast
	 */
	public function __construct($simpleforecast)
	{
		$this->forecastday = array_map(function ($day) { return new WuWeatherStandardResponseSimpleforecastDayModel($day); }, $simpleforecast->forecastday);
	}
}

class WuWeatherStandardResponseSimpleforecastDayModel extends WuWeatherStandardResponseForecastDayModel
{
	/**
	 * @var DateTime
	 */
	public $date = null;

	/**
	 * @var WuWeatherRequestTemperatureModel
	 */
	public $high = null;

	/**
	 * @var WuWeatherRequestTemperatureModel
	 */
	public $low = null;

	/**
	 * @var string
	 */
	public $skyicon = '';

	/**
	 * @var string
	 */
	public $conditions = '';

	/**
	 * @var WuWeatherRequestQPFModel
	 */
	public $qpf_allday = null;

	/**
	 * @var WuWeatherRequestQPFModel
	 */
	public $qpf_day = null;

	/**
	 * @var WuWeatherRequestQPFModel
	 */
	public $qpf_night = null;

	/**
	 * @var WuWeatherRequestSnowModel
	 */
	public $snow_allday = null;

	/**
	 * @var WuWeatherRequestSnowModel
	 */
	public $snow_day = null;

	/**
	 * @var WuWeatherRequestSnowModel
	 */
	public $snow_night = null;

	/**
	 * @var WuWeatherRequestWindModel
	 */
	public $maxwind = null;

	/**
	 * @var WuWeatherRequestWindModel
	 */
	public $avewind = null;

	/**
	 * @var int
	 */
	public $avehumidity = 0;

	/**
	 * @var int
	 */
	public $maxhumidity = 0;

	/**
	 * @var int
	 */
	public $minhumidity = 0;

	/**
	 * WuWeatherStandardResponseForecastDayModel constructor.
	 *
	 * @param stdClass $forecastday
	 */
	public function __construct($forecastday)
	{

		parent::__construct($forecastday);

		$this->date = date_create('')->setTimestamp($this->date->epoch)->setTimezone(new DateTimeZone($this->date->tz_long));
		
		$this->high = new WuWeatherRequestTemperatureModel($this->high);
		$this->low  = new WuWeatherRequestTemperatureModel($this->low);

		$this->qpf_allday = new WuWeatherRequestQPFModel($this->qpf_allday);
		$this->qpf_day    = new WuWeatherRequestQPFModel($this->qpf_day);
		$this->qpf_night  = new WuWeatherRequestQPFModel($this->qpf_night);

		$this->snow_allday = new WuWeatherRequestSnowModel($this->snow_allday);
		$this->snow_day    = new WuWeatherRequestSnowModel($this->snow_day);
		$this->snow_night  = new WuWeatherRequestSnowModel($this->snow_night);

		$this->maxwind = new WuWeatherRequestWindModel($this->maxwind);
		$this->avewind = new WuWeatherRequestWindModel($this->avewind);
	}
}