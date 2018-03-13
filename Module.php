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

class Module extends \yii\base\Module
{
	public static $_LANG_EN = 'en';
	public static $_LANG_FA = 'fa-IR';
	public static $_LANG_AR = 'ar-SA';


    public $language_array;
    public $default_language;

    private function validate_default_language($code) {
        return ($code == self::$_LANG_EN || $code == self::$_LANG_FA || $code == self::$_LANG_AR);
    }

    private function validate_language_array() {
        if(!is_array($this->language_array))
            return false;
        foreach($this->language_array as $language_key => $language_item)
        {
            if(!is_array($language_item) || !$this->validate_default_language($language_key))
                return false;
        }
        return true;
    }

    public function init()
    {
        parent::init();

        if (empty(Yii::$app->i18n->translations['base']))
		{
            Yii::$app->i18n->translations['base'] =
			[
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
            Yii::$app->i18n->translations['coding'] =
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }
        if(!isset($this->default_language) || !$this->validate_default_language($this->default_language))
        {
            // TODO: raise warning when is not validated
            $this->default_language = 'fa-IR';
        }
        if(!isset($this->language_array) || !$this->validate_language_array())
        {
            // TODO: raise warning when is not validated
            $this->language_array = [
                'fa-IR' => [
                    'name' => 'Persian',
                    'dir' => 'rtl'
                ],
                'en' => [
                    'name' => 'English',
                    'dir' => 'ltr'
                ],
                'ar-SA' => [
                    'name' => 'Arabic',
                    'dir' => 'rtl'
                ],
            ];
        }
    }

    public static function t($message, $category = 'base', $params = [], $language = null)
    {
        return \Yii::t($category, $message, $params, $language);
    }

    public function getLanguages()
    {
        $languages = [];
        $keys = array_keys($this->language_array);
        foreach ($keys as $key)
            $languages[$key] = self::t($key, 'coding');
        return $languages;
    }

    public function hasLanguage($code)
    {
        foreach($this->language_array as $key => $value)
            if($code == $key)
                return true;
        return false;
    }
	
}
