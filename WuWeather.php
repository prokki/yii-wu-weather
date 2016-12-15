<?php



class WuWeather extends CApplicationComponent
{
	
	const DISTANCE_UNIT_METER = 'meter';
	const DISTANCE_UNIT_MILES = 'miles';
	
	/**
	 * Your API key. You can request a key on the sign in page. This is used in most API calls (with the exception of the AutoComplete API).
	 *
	 * @var string
	 */
	public $apiKey = '';

	/**
	 * @var bool|mixed[]
	 */
	public $cache = false;

	public function init()
	{
		parent::init();
		
		$path_alias = self::GetPathAlias();
		
		Yii::import(sprintf('%s.%s', $path_alias, 'models.*'));
		Yii::import(sprintf('%s.%s', $path_alias, 'models.response.*'));
		Yii::import(sprintf('%s.%s', $path_alias, 'models.response.units.*'));
		Yii::import(sprintf('%s.%s', $path_alias, 'requests.*'));
		Yii::import(sprintf('%s.%s', $path_alias, 'widgets.renderer.*'));
		Yii::import(sprintf('%s.%s', $path_alias, 'transformer.*'));
	}
	
	public static function GetPathAlias()
	{
		return sprintf('ext.%s', basename(__DIR__));
	}
	
	/**
	 * @return WuWeatherStandardRequest
	 */
	public function standardRequest()
	{
		$request = new WuWeatherStandardRequest($this);

		if( !is_null($this->cache) && $this->cache !== false )
		{
			$request->enableCache();
			
			if( array_key_exists("lifetime", $this->cache) )
			{
				$request->getCache()->setLifetime((int) $this->cache[ 'lifetime']);
			}

			if( array_key_exists("distance", $this->cache) )
			{
				$unit = WuWeather::DISTANCE_UNIT_METER;
				
				if(array_key_exists("unit", $this->cache))
				{
					$unit = $this->cache['unit'];
				}
				
				$request->getCache()->setDistance((int) $this->cache['distance'], $unit);
			}
		}

		return $request;
	}
}
