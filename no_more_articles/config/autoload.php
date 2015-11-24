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
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'ArticleModel'      => 'system/modules/no_more_articles/models/ArticleModel.php',
    'ModuleArticle'     => 'system/modules/no_more_articles/modules/ModuleArticle.php'
));
