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
 * Fixing navigation
 */
array_insert($GLOBALS['BE_MOD']['content'], 0, array
(
    'page' => array
    (
        'tables' => array('tl_page','tl_content')
    )
));
unset($GLOBALS['BE_MOD']['design']['page']);
unset($GLOBALS['BE_MOD']['content']['article']);

/**
 * Removing content elements
 */
unset($GLOBALS['TL_CTE']['includes']['article']);
unset($GLOBALS['TL_CTE']['includes']['teaser']);

/**
 * Removing front end modules
 */
unset($GLOBALS['FE_MOD']['navigationMenu']['articlenav']);
unset($GLOBALS['FE_MOD']['miscellaneous']['articleList']);
