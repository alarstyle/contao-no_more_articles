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
 * Dynamically add the permission check and parent table
 */
if (Input::get('do') == 'page')
{
    $GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_page';
    //$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('tl_content_news', 'checkPermission');
}


$GLOBALS['TL_DCA']['tl_content']['fields']['cteAlias']['options_callback'] = array('tl_content_no_more_articles', 'getAlias');


class tl_content_no_more_articles extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Get all content elements and return them as array (content element alias)
     */
    public function getAlias()
    {
        $arrPids = array();
        $arrAlias = array();

        if (!$this->User->isAdmin)
        {
            foreach ($this->User->pagemounts as $id)
            {
                $arrPids[] = $id;
                $arrPids = array_merge($arrPids, $this->Database->getChildRecords($id, 'tl_page'));
            }

            if (empty($arrPids))
            {
                return $arrAlias;
            }

            $objAlias = $this->Database->prepare("SELECT c.id, c.pid, c.type, (CASE c.type WHEN 'module' THEN m.name WHEN 'form' THEN f.title WHEN 'table' THEN c.summary ELSE c.headline END) AS headline, c.text, a.title FROM tl_content c LEFT JOIN tl_page a ON a.id=c.pid LEFT JOIN tl_module m ON m.id=c.module LEFT JOIN tl_form f on f.id=c.form WHERE a.pid IN(". implode(',', array_map('intval', array_unique($arrPids))) .") AND (c.ptable='tl_page') AND c.id!=? ORDER BY a.title, c.sorting")
                ->execute(Input::get('id'));
        }
        else
        {
            $objAlias = $this->Database->prepare("SELECT c.id, c.pid, c.type, (CASE c.type WHEN 'module' THEN m.name WHEN 'form' THEN f.title WHEN 'table' THEN c.summary ELSE c.headline END) AS headline, c.text, a.title FROM tl_content c LEFT JOIN tl_page a ON a.id=c.pid LEFT JOIN tl_module m ON m.id=c.module LEFT JOIN tl_form f on f.id=c.form WHERE (c.ptable='tl_page') AND c.id!=? ORDER BY a.title, c.sorting")
                ->execute(Input::get('id'));
        }

        while ($objAlias->next())
        {
            $arrHeadline = deserialize($objAlias->headline, true);

            if (isset($arrHeadline['value']))
            {
                $headline = StringUtil::substr($arrHeadline['value'], 32);
            }
            else
            {
                $headline = StringUtil::substr(preg_replace('/[\n\r\t]+/', ' ', $arrHeadline[0]), 32);
            }

            $text = StringUtil::substr(strip_tags(preg_replace('/[\n\r\t]+/', ' ', $objAlias->text)), 32);
            $strText = $GLOBALS['TL_LANG']['CTE'][$objAlias->type][0] . ' (';

            if ($headline != '')
            {
                $strText .= $headline . ', ';
            }
            elseif ($text != '')
            {
                $strText .= $text . ', ';
            }

            $key = $objAlias->title . ' (ID ' . $objAlias->pid . ')';
            $arrAlias[$key][$objAlias->id] = $strText . 'ID ' . $objAlias->id . ')';
        }

        return $arrAlias;
    }
}