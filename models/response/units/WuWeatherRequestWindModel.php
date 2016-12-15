<?php

class WuWeatherRequestWindModel extends WuWeatherRequestUnitModel
{
	/**
	 * @var int
	 */
	public $mph = 0;

	/**
	 * @var int
	 */
	public $kph = 0;

	/**
	 * @var string
	 */
	public $dir = '';

	/**
	 * @var int
	 */
	public $degrees = 0;

	/**
	 * WuWeatherRequestSnowModel constructor.
	 *
	 * @param stdClass $wind
	 */
	public function __construct($wind)
	{
		$this->_isset(!is_null($wind->mph));

		$this->mph     = (int) $wind->mph;
		$this->kph     = (int) $wind->kph;
		$this->dir     = $wind->dir;
		$this->degrees = (int) $wind->degrees;
	}
}