<?php

/**
 * This is the model class for table 'user'.
 *
 * The followings are the available columns in table 'user':
 *
 * @property int    $id
 * @property string $datetime
 * @property string $request
 * @property string $response
 * @property string $language
 * @property bool   $pws
 * @property bool   $bestfct
 * @property float  $query_lat
 * @property float  $query_lon
 * @property bool   $forecast
 *
 */
class WuWeatherStandardCacheModel extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 *
	 * @param string $className active record class name.
	 *
	 * @return $this
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns the associated database table name.
	 *
	 * @return   String
	 */
	public function tableName()
	{
		return '{{wu_weather_standard}}';
	}

	public function init()
	{
		// use ```Yii::app()->getDb()``` instead of ```$this->dbConnection``` to avoid CDbException and errors
		// like ```SQLSTATE[42S02]: Base table or view not found: 1146 Table 'wu_weather.abc__wu_weather_standard' doesn't exist. [...]```
		if( is_null(Yii::app()->getDb()->getSchema()->getTable($this->tableName())) )
		{
			$this->_install();

			$this->refreshMetaData();
		}
	}

	public function _install()
	{
		// use ```Yii::app()->getDb()``` instead of ```$this->dbConnection``` to avoid CDbException and errors
		// like ```SQLSTATE[42S02]: Base table or view not found: 1146 Table 'wu_weather.abc__wu_weather_standard' doesn't exist. [...]```
		Yii::app()->getDb()->createCommand(
			Yii::app()->getDb()->getSchema()->createTable($this->tableName(), array(
				'id'        => 'INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'request'   => 'TEXT NOT NULL',
				'response'  => 'TEXT NOT NULL',
				'datetime'  => 'DATETIME NOT NULL',
				'language'  => 'VARCHAR(2)',
				'pws'       => 'BOOLEAN NOT NULL',
				'bestfct'   => 'BOOLEAN NOT NULL',
				'query_lat' => 'FLOAT(5, 2) NOT NULL',
				'query_lon' => 'FLOAT(5, 2) NOT NULL',
				'forecast'  => 'BOOLEAN NOT NULL DEFAULT 0',
			))
		)->execute();
	}

	/**
	 * @return   String[]
	 */
	public function rules()
	{
		return array(
			array('id', 'numerical', 'integerOnly' => true, 'min' => 1),
			array('id', 'length', 'max' => 10),
			array('request', 'required'),
			array('response', 'required'),
			array('datetime', 'default', 'value' => date_create()->format("Y-m-d H:i:s")),
			array('datetime', 'date', 'format' => 'yyyy-M-d H:m:s', 'allowEmpty' => false),
			array('language', 'length', 'max' => 2, 'allowEmpty' => false),
			array('pws', 'boolean'),
			array('bestfct', 'boolean'),
			array('query_lat', 'numerical', 'max' => 360.0, 'min' => -360.0),
			array('query_lon', 'numerical', 'max' => 360.0, 'min' => -360.0),
			array('forecast', 'boolean'),
		);
	}

//	public function beforeValidate()
//	{
//
//		if( $this->isNewRecord )
//		{
//			$this->datetime = date_create()->format("Y-m-d H:i:s");
//		}
//
//		return parent::beforeValidate();
//	}

	/**
	 * @param $lifetime
	 *
	 * @return $this
	 */
	public function lifetime($lifetime)
	{

		$this->dbCriteria->addCondition('datetime > DATE_SUB(:now, INTERVAL :seconds SECOND)');
		$this->dbCriteria->params[ ':now' ]     = date_create()->format("Y-m-d H:i:s");
		$this->dbCriteria->params[ ':seconds' ] = $lifetime;
		
		$this->dbCriteria->order = 'datetime DESC';

		return $this;
	}

	/**
	 * @param float  $lat
	 * @param float  $lon
	 * @param int    $distance
	 * @param string $unit
	 *
	 * @return $this
	 *
	 * @link http://stackoverflow.com/a/35768788/4351778
	 */
	public function distance($lat, $lon, $distance, $unit)
	{
		$this->dbCriteria->addCondition(sprintf('
			:distance > ACOS(
				  SIN( :lat * PI() / 180 ) * SIN( query_lat * PI() / 180)
				+ COS( :lat * PI() / 180 ) * COS( query_lat * PI() / 180) * COS(
					  query_lon * PI() / 180
					-      :lon * PI() / 180
				  )
			) * %d', ( $unit === WuWeather::DISTANCE_UNIT_METER ) ? 6367 : 3957));
		$this->dbCriteria->params[ ':lat' ]      = $lat;
		$this->dbCriteria->params[ ':lon' ]      = $lon;
		$this->dbCriteria->params[ ':distance' ] = $distance;

		return $this;
	}


}