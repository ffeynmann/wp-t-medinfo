<?php
//defined('ABSPATH') or die("No script kiddies please!");
//if (function_exists('add_theme_support')) {
//add_theme_support("widgets");
//add_theme_support("menus");
//add_theme_support("post-thumbnails");
//}
//
//function autoload($className)
//{
//	$className = ltrim($className, '\\');
//	$fileName  = '';
//	$namespace = '';
//	if ($lastNsPos = strrpos($className, '\\')) {
//		$namespace = substr($className, 0, $lastNsPos);
//		$className = substr($className, $lastNsPos + 1);
//		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
//	}
//	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
//
//	require $fileName;
//}
//spl_autoload_register('autoload');

if (function_exists('add_theme_support')) {
    add_theme_support("widgets");
    add_theme_support("menu");
    add_theme_support("post-thumbnails");
}

include(__DIR__ . '/App/Sitemp.php');
include(__DIR__ . '/App/FacebookX.php');
include(__DIR__ . '/App/Posts.php');
include(__DIR__ . '/App/Bot.php');
include(__DIR__ . '/App/Comments.php');
include(__DIR__ . '/App/Ajax.php');
include(__DIR__ . '/App/Language.php');
include(__DIR__ . '/App/PostTypesTaxonomies.php');
include(__DIR__ . '/App/Helper.php');
include(__DIR__ . '/App/Company.php');
//include(__DIR__ . '/App/Search.php');
include(__DIR__ . '/App/SEO.php');
include(__DIR__ . '/App/Captcha.php');
include(__DIR__ . '/App/DoctorsHelper.php');
include(__DIR__ . '/App/Base.php');

\App\Base::init();
