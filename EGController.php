<?php

namespace elephantsGroup\base;

/*
	Name: eg-base
	Description: ElephantsGroup base module for Yii 2
	Authors: Jalal Jaberi (proodoo@gmail.com), Arezou Zahedi Majd (arezoumajd@google.com)
	Website : http://elephantsgroup.com
	Revision date : 2018/03/13
*/

use Yii;
use yii\web;
use elephantsGroup\base\Module;

class EGController extends \yii\web\Controller
{
	public $language;
	public $direction = 'rtl';
	protected $language_urls = [];
	protected $options = [];

	public $description = "ElephantsGroup EGCMS Platform";
	public $keywords = array('ElephantsGroup', 'egcms', 'پلتفرم EGCMS');
	public $title = "ElephantsGroup EGCMS Platform";
	
    public function bindActionParams($action, $params)
	{
        $module = \Yii::$app->getModule('base');
		if(isset($params['lang']) && $module->hasLanguage($params['lang']))
			Yii::$app->language = $this->language = $params['lang'];
        else
            Yii::$app->language = $this->language = $module->default_language;
		// TODO: raise warning when incorrect parameter

		if(isset($module->language_array[$this->language]['dir']))
	        $this->direction = $module->language_array[$this->language]['dir'];

        return parent::bindActionParams($action, $params);
	}

	public function addLanguageUrl($lang, $url, $active = false)
	{
		if(!isset($url) || $url == '')
			 $url = Yii::getAlias('@web');
		$this->language_urls[$lang] = ['url'=>$url, 'active'=>$active];
	}

	public function getLanguageUrls()
	{
		return $this->language_urls;
	}

	public function setOption($key, $value)
	{
		$this->options[$key] = $value;
	}

	public function isSetOption($key)
	{
		return isset($this->options[$key]);
	}

	public function getOption($key)
	{
		if(!isSetOption($key))
			throw Exception('Unexpected $key for EGController getOption function');
		return $this->options[$key];
	}

	public function beforeAction($action)
	{
		if (in_array('elephantsGroup\stat\traits\StatTrait', class_uses($this)))
			$this->log();
		return parent::beforeAction($action);
	}
}
