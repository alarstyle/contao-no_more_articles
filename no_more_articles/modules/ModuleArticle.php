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
 * Overriding original module
 */
class ModuleArticle extends \Module
{

	protected $strTemplate = 'mod_article_plain';


	public function generate($blnNoMarkup)
	{
		$this->type = 'article';

		return parent::generate();
	}


	protected function compile()
	{
		global $objPage;

		$arrElements = array();
		$objCte = \ContentModel::findPublishedByPidAndTable($objPage->id, 'tl_page');

		if ($objCte !== null)
		{
			$intCount = 0;
			$intLast = $objCte->count() - 1;

			while ($objCte->next())
			{
				$arrCss = array();

				/** @var \ContentModel $objRow */
				$objRow = $objCte->current();

				// Add the "first" and "last" classes (see #2583)
				if ($intCount == 0 || $intCount == $intLast)
				{
					if ($intCount == 0)
					{
						$arrCss[] = 'first';
					}

					if ($intCount == $intLast)
					{
						$arrCss[] = 'last';
					}
				}

				$objRow->classes = $arrCss;
				$arrElements[] = $this->getContentElement($objRow, $this->strColumn);
				++$intCount;
			}
		}

		$this->Template->elements = $arrElements;

		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['compileArticle']) && is_array($GLOBALS['TL_HOOKS']['compileArticle']))
		{
			foreach ($GLOBALS['TL_HOOKS']['compileArticle'] as $callback)
			{
				$this->import($callback[0]);
				$this->$callback[0]->$callback[1]($this->Template, $this->arrData, $this);
			}
		}
	}


	public function generatePdf()
	{
		exit;
	}
}
