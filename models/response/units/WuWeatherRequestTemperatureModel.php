<?php

class WuWeatherRequestTemperatureModel extends WuWeatherRequestUnitModel
{
	/**
	 * @var int
	 */
	public $fahrenheit = 0;

	/**
	 * @var int
	 */
	public $celsius = 0;
	
	/**
	 * WuWeatherRequestTemperatureModel constructor.
	 *
	 * @param stdClass $temperature
	 */
	public function __construct($temperature)
	{
		$this->_isset(!is_null($temperature->fahrenheit));
		
		$this->fahrenheit = (int) $temperature->fahrenheit;

		$this->celsius = (int) $temperature->celsius;
	}
}