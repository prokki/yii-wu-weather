<?php

/**
 *
 * @author   Falko Matthies <falko.m@web.de>
 * @since    2016-12-15
 */
class WuWeatherStandardForecastRenderer extends WuWeatherStandardRenderer
{


	public function init()
	{
		$this->feature = 'forecast';
		
		$this->templateFile = 'forecast';
		
		parent::init();
	}

}

?>