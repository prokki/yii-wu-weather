<?php

abstract class WuWeatherCache
{
	protected $_enabled = false;

	/**
	 * @var CDbConnection
	 */
	protected $_db = null;

	/**
	 * @var string
	 */
	protected $_table = '';

	/**
	 * @var int
	 */
	protected $_lifetime = 3600;

	/**
	 * @var int
	 */
	protected $_distance = 300;

	/**
	 * @var string
	 */
	protected $_distanceUnit = WuWeather::DISTANCE_UNIT_METER;

	/**
	 * @param int $lifetime
	 */
	public function setLifetime($lifetime)
	{
		$this->_lifetime = $lifetime;
	}

	/**
	 * @param int    $distance
	 * @param string $unit
	 */
	public function setDistance($distance, $unit)
	{
		$unit = strtolower($unit);

		if( $unit !== WuWeather::DISTANCE_UNIT_METER && $unit !== WuWeather::DISTANCE_UNIT_MILES )
		{
			throw new InvalidArgumentException("unit must be meter or miles");
		}

		$this->_distanceUnit = $unit;
		$this->_distance     = $distance;
	}

	/**
	 * @param WuWeatherRequest $request
	 * @param string           $response
	 */
	abstract public function save($request, $response);

	/**
	 * @param WuWeatherRequest $request
	 *
	 * @return string
	 */
	abstract public function load($request);

}