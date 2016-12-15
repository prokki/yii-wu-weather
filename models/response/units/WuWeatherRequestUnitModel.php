<?php

abstract class WuWeatherRequestUnitModel
{
	/**
	 * @var bool
	 */
	public $isset = false;

	protected function _isset($isset = true)
	{
		$this->isset = $isset;
	}
}