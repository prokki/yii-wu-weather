<?php

class WuWeatherRequestSnowModel extends WuWeatherRequestUnitModel
{
	/**
	 * @var float
	 */
	public $in = .0;


	/**
	 * @var float
	 */
	public $cm = .0;

	/**
	 * WuWeatherRequestSnowModel constructor.
	 *
	 * @param stdClass $snow
	 */
	public function __construct($snow)
	{
		$this->_isset(!is_null($snow->in));
		
		$this->in = (float) $snow->in;

		$this->cm = (float) $snow->cm;
	}
}