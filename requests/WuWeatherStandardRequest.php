<?php

class WuWeatherStandardRequest extends WuWeatherRequest
{
	const URL = "http://api.wunderground.com/api/{API_KEY}/{FEATURES}{SETTINGS}/q/{QUERY}.{FORMAT}";

	/**
	 * One or more of the following data features. Note that these can be combined into a single request: geolookup/conditions/forecast
	 *
	 * @var string[]
	 */
	private $_features = array();

	/**
	 * @var string
	 */
	private $_language = "EN";

	/**
	 * @var bool
	 */
	private $_pws = true;

	/**
	 * @var bool
	 */
	private $_bestfct = true;
	

	/**
	 * @var string
	 */
	private $_query = "autoip";
	
	/**
	 * @var float
	 */
	private $_lat = .0;

	/**
	 * @var float
	 */
	private $_lon = .0;
	
	/**
	 * WuWeatherStandardRequest constructor.
	 *
	 * @param string $api_key
	 */
	public function __construct($component)
	{
		parent::__construct($component, self::URL);

		$this->_language = self::_DefaultLanguage();
		$this->_pws      = self::_DefaultPws();
		$this->_bestfct  = self::_DefaultBestFCT();
	}

	protected static function _DefaultLanguage()
	{
		return 'EN';
	}

	protected static function _DefaultPws()
	{
		return true;
	}

	protected static function _DefaultBestFCT()
	{
		return true;
	}

	/**
	 * @return string[]
	 */
	public static function getValidFeatures()
	{
		return array(
			'alerts',
			'almanac',
			'astronomy',
			'conditions',
			'currenthurricane',
			'forecast',
			'forecast10day',
			'geolookup',
			'history',
			'hourly',
			'hourly10day',
			'planner',
			'rawtide',
			'tide',
			'webcams',
			'yesterday',
		);
	}

	/**
	 * @return string[]
	 */
	public static function getValidLanguages()
	{
		return array(
			 "AF" => " Afrikaans",
			 "AL" => " Albanian",
			 "AR" => " Arabic",
			 "HY" => " Armenian",
			 "AZ" => " Azerbaijani",
			 "EU" => " Basque",
			 "BY" => " Belarusian",
			 "BU" => " Bulgarian",
			 "LI" => " British English",
			 "MY" => " Burmese",
			 "CA" => " Catalan",
			 "CN" => " Chinese - Simplified",
			 "TW" => " Chinese - Traditional",
			 "CR" => " Croatian",
			 "CZ" => " Czech",
			 "DK" => " Danish",
			 "DV" => " Dhivehi",
			 "NL" => " Dutch",
			 "EN" => " English",
			 "EO" => " Esperanto",
			 "ET" => " Estonian",
			 "FA" => " Farsi",
			 "FI" => " Finnish",
			 "FR" => " French",
			 "FC" => " French Canadian",
			 "GZ" => " Galician",
			 "DL" => " German",
			 "KA" => " Georgian",
			 "GR" => " Greek",
			 "GU" => " Gujarati",
			 "HT" => " Haitian Creole",
			 "IL" => " Hebrew",
			 "HI" => " Hindi",
			 "HU" => " Hungarian",
			 "IS" => " Icelandic",
			 "IO" => " Ido",
			 "ID" => " Indonesian",
			 "IR" => " Irish Gaelic",
			 "IT" => " Italian",
			 "JP" => " Japanese",
			 "JW" => " Javanese",
			 "KM" => " Khmer",
			 "KR" => " Korean",
			 "KU" => " Kurdish",
			 "LA" => " Latin",
			 "LV" => " Latvian",
			 "LT" => " Lithuanian",
			 "ND" => " Low German",
			 "MK" => " Macedonian",
			 "MT" => " Maltese",
			 "GM" => " Mandinka",
			 "MI" => " Maori",
			 "MR" => " Marathi",
			 "MN" => " Mongolian",
			 "NO" => " Norwegian",
			 "OC" => " Occitan",
			 "PS" => " Pashto",
			 "GN" => " Plautdietsch",
			 "PL" => " Polish",
			 "BR" => " Portuguese",
			 "PA" => " Punjabi",
			 "RO" => " Romanian",
			 "RU" => " Russian",
			 "SR" => " Serbian",
			 "SK" => " Slovak",
			 "SL" => " Slovenian",
			 "SP" => " Spanish",
			 "SI" => " Swahili",
			 "SW" => " Swedish",
			 "CH" => " Swiss",
			 "TL" => " Tagalog",
			 "TT" => " Tatarish",
			 "TH" => " Thai",
			 "TR" => " Turkish",
			 "TK" => " Turkmen",
			 "UA" => " Ukrainian",
			 "UZ" => " Uzbek",
			 "VU" => " Vietnamese",
			 "CY" => " Welsh",
			 "SN" => " Wolof",
			 "JI" => " Yiddish - transliterated",
			 "YI" => " Yiddish - unicode",
		);
	}
	
	/**
	 * @param $language
	 *
	 * @return bool
	 */
	protected static function _ValidLanguage($language)
	{
		return in_array($language, array_keys(self::getValidLanguages()));
	}

	protected static function _ValidFeature($feature)
	{
		return in_array($feature, self::getValidFeatures());
	}

	public function enableCache()
	{
		$this->_cache = new WuWeatherStandardCache();
	}

	/**
	 * @param string $feature
	 *
	 * @return $this
	 */
	public function addFeature($feature)
	{
		if( !self::_ValidFeature(strtolower($feature)) )
		{
			throw new RuntimeException(sprintf('unknown feature %s', $feature));
		}

		array_push($this->_features, strtolower($feature));

		$this->_features = array_unique($this->_features);

		return $this;
	}

	/**
	 * @param string $features
	 *
	 * @return $this
	 */
	public function setFeatures($features)
	{
		array_map(array($this, 'addFeature'), $features);

		return $this;
	}

	/**
	 * @param string $feature
	 *
	 * @return bool
	 */
	public function hasFeature($feature)
	{
		return in_array(strtolower($feature), $this->_features);
	}
	
	/**
	 * @param string $language
	 *
	 * @return $this
	 */
	public function setLanguage($language)
	{
		if( !self::_ValidLanguage(strtoupper($language)) )
		{
			throw new RuntimeException(sprintf('unknown language %s', $language));
		}
		
		$this->_language = strtoupper($language);
		
		return $this;
	}

	/**
	 * @param float $lat
	 * @param float $lon
	 *
	 * @return $this
	 */
	public function setLocation($lat, $lon)
	{
		$this->_lat = round($lat, 2);
		$this->_lon = round($lon, 2);
		
		$this->_query = sprintf("%.2f,%.2f", $this->_lat, $this->_lon);
		
		return $this;
	}
	
	/**
	 *
	 * @return $this
	 */
	public function enablePws()
	{
		$this->_pws = true;
		
		return $this;
	}

	/**
	 *
	 * @return $this
	 */
	public function disablePws()
	{
		$this->_pws = false;

		return $this;
	}
	
	/**
	 *
	 * @return $this
	 */
	public function enableBestFCS()
	{
		$this->_bestfct = true;
		
		return $this;
	}

	/**
	 *
	 * @return $this
	 */
	public function disableBestFCS()
	{
		$this->_bestfct = false;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getFeatures()
	{
		return $this->_features;
	}

	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * @return bool
	 */
	public function isPws()
	{
		return $this->_pws;
	}

	/**
	 * @return bool
	 */
	public function isBestfct()
	{
		return $this->_bestfct;
	}

	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->_lat;
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->_lon;
	}

	protected function _validParameters()
	{
		parent::_validParameters();

		if( empty( $this->_features ) )
		{
			throw new RuntimeException('features must not be empty');
		}
		else if( empty( $this->_query ) )
		{
			throw new RuntimeException('query must not be empty');
		}
		else if( empty( $this->_format ) )
		{
			throw new RuntimeException('query must not be empty');
		}
	}

	private function _getUrlParameterFeature()
	{
		return implode("/", $this->_features);
	}

	private function _getUrlParameterSettings()
	{
		$params = array();

		if( $this->_language !== self::_DefaultLanguage() )
		{
			array_push($params, sprintf("lang:%s", $this->_language));
		}
		
		if( $this->_pws !== self::_DefaultPws() )
		{
			array_push($params, sprintf("pws:%d", $this->_pws));
		}

		if( $this->_bestfct !== self::_DefaultBestFCT() )
		{
			array_push($params, sprintf("bestfcs:%d", $this->_bestfct));
		}

		return empty( $params ) ? "" : ( "/" . implode("/", $params) );
	}

	protected function _getRequestUrlWithParameter()
	{
		$call_url = str_replace("{FEATURES}", $this->_getUrlParameterFeature(), parent::_getRequestUrlWithParameter());

		$call_url = str_replace("{SETTINGS}", $this->_getUrlParameterSettings(), $call_url);

		$call_url = str_replace("{QUERY}", $this->_query, $call_url);

		return $call_url;
	}

}
