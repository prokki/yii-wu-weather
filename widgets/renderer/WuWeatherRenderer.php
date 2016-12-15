<?php

/**
 *
 * @author   Falko Matthies <falko.m@web.de>
 * @since    2016-12-15
 */
class WuWeatherRenderer extends CWidget
{

	const WU_WEATHER_VERSION = '0.1';

	/**
	 * the absolute url to the published assets path
	 *
	 * @var string
	 */
	private $_pathAlias = "";

	/**
	 * @return string
	 */
	protected function _getPathAlias()
	{
		if( empty($this->_pathAlias) )
		{
			$this->_pathAlias = sprintf('%s.%s', WuWeather::GetPathAlias(), 'widgets.renderer');
		}
		return $this->_pathAlias;
	}

	/**
	 * Overrides {@link CWidget::init()}.<br/>
	 * Initializes the widget.
	 */
	public function init()
	{
		// publish assets
		#$this->_assetsUrl = Yii::app()->getAssetManager()->publish(sprintf("%s.assets", $this->_getPathAlias()));

		// always set id
		if( !isset($this->id) )
		{
			$this->getId();
		}
		
		// cal parent init method
		parent::init();
	}



}

?>