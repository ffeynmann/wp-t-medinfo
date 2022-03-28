<?php

namespace App;

class Language {
    public static $current          = null;
    public static $currentHuman     = null;
    public static $anotherHuman     = null;
    public static $currentHumanFull = null;
    public static $anotherHumanFull = null;
    public static $anotherLink      = null;

    public static function init()
    {
        self::$current          = qtranxf_getLanguage();
        self::$currentHuman     = self::$current == 'ua' ? 'Укр' : 'Рус';
        self::$currentHumanFull = self::$current == 'ua' ? 'Украинский' : 'Русский';
        self::$anotherLink      = Language::linkAnotherLanguage();
        self::$anotherHuman     = self::$current == 'ru' ? 'Укр' : 'Рус';
        self::$anotherHumanFull = self::$current == 'ru' ? 'Украинский' : 'Русский';
    }

    public static function linkAnotherLanguage()
    {
        global $wp;

        return qtranxf_convertURL($wp->request, Language::getAnotherLanguage());
    }

    public static function getAnotherLanguage()
    {
        $current   = qtranxf_getLanguage();
        $languages = qtranxf_getSortedLanguages();

        return current(array_diff($languages, [$current]));
    }

}