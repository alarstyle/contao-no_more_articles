<?php

/**
 * No More Articles for Contao Open Source CMS
 *
 * Copyright (C) 2015 Alexander Stulnikov
 *
 * @link       https://github.com/alarstyle/contao-no_more_articles
 * @license    http://opensource.org/licenses/MIT
 */


/**
 * Overriding original model
 */
class ArticleModel extends Contao\ArticleModel
{

	public static function findByIdOrAliasAndPid($varId, $intPid, array $arrOptions=array())
	{
		// Do nothing is call from insert tag
		if (is_null($intPid))
		{
			return null;
		}

		// Create a dummy model
		return new \ArticleModel();
	}


	public static function findPublishedByPidAndColumn($intPid, $strColumn, array $arrOptions=array())
	{
		// Create a dummy collection
		return static::createCollection(array( new \ArticleModel() ), static::$strTable);
	}

}
