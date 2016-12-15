<?php

class WuWeatherRequestQPFModel extends WuWeatherRequestUnitModel
{
	/**
	 * @var float
	 */
	public $in = .0;

	/**
	 * @var int
	 */
	public $mm = 0;

	/**
	 * WuWeatherRequestQPFModel constructor.
	 *
	 * @param stdClass $qpf
	 */
	public function __construct($qpf)
	{
		$this->_isset(!is_null($qpf->in));

		$this->in = (float) $qpf->in;

		$this->mm = (int) $qpf->mm;
	}
}