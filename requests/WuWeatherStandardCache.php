<?php

class WuWeatherStandardCache extends WuWeatherCache
{

	public function __construct()
	{
		$model = WuWeatherStandardCacheModel::model()->init();
	}

	/**
	 * @param WuWeatherStandardRequest $request
	 * @param string                   $response
	 *
	 * @return bool
	 */
	public function save($request, $response)
	{
		$model = new WuWeatherStandardCacheModel();

		$model->bestfct   = $request->isBestfct();
		$model->request   = 'aaa';
		$model->response  = $response;
		$model->pws       = $request->isPws();
		$model->forecast  = $request->hasFeature('forecast');
		$model->language  = $request->getLanguage();
		$model->query_lat = $request->getLatitude();
		$model->query_lon = $request->getLongitude();

		if( !$model->save() )
		{
			trigger_error('unable to cache weather data', E_USER_WARNING);

			return false;
		}

		return true;
	}

	/**
	 * @param WuWeatherStandardRequest $request
	 *
	 * @return string
	 */
	public function load($request)
	{
		$model = WuWeatherStandardCacheModel::model()
			->lifetime($this->_lifetime)
			->distance(
				$request->getLatitude(),
				$request->getLongitude(),
				$this->_distance,
				$this->_distanceUnit
			)
			->find();

		if( !is_null($model) )
		{
			return $model->response;
		}
		
		return '';
	}

}