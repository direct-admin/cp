<?php

/*
 * Copyright 2004-2015, AfterLogic Corp.
 * Licensed under AGPLv3 license or AfterLogic license
 * if commercial version of the product was purchased.
 * See the LICENSE file for a full license statement.
 */

namespace MailSo;

if (!\defined('MAILSO_LIBRARY_ROOT_PATH'))
{
	\define('MAILSO_LIBRARY_ROOT_PATH', \defined('MAILSO_LIBRARY_USE_PHAR')
		? 'phar://mailso.phar/' : \rtrim(\realpath(__DIR__), '\\/').'/');

	/**
	 * @param string $sClassName
	 *
	 * @return mixed
	 */
	function MailSoSplAutoloadRegisterFunction($sClassName)
	{
		return (0 === \strpos($sClassName, 'MailSo') && false !== \strpos($sClassName, '\\')) ?
			include MAILSO_LIBRARY_ROOT_PATH.\str_replace('\\', '/', \substr($sClassName, 7)).'.php' : false;
	}

	\spl_autoload_register('MailSo\MailSoSplAutoloadRegisterFunction', false);

	if (\class_exists('MailSo\Base\Loader'))
	{
		\MailSo\Base\Loader::Init();
	}
	else
	{
		\spl_autoload_unregister('MailSo\MailSoSplAutoloadRegisterFunction');
	}
}