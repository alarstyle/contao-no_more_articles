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
 * Add child table
 */
$GLOBALS['TL_DCA']['tl_page']['config']['ctable'] = array('tl_content');


/**
 * Modifying pages operations
 */
$GLOBALS['TL_DCA']['tl_page']['list']['operations']['edit'] = array
(
    'label'               => &$GLOBALS['TL_LANG']['tl_page']['edit'],
    'href'                => 'table=tl_content',
    'icon'                => 'edit.gif',
    'button_callback'     => array('tl_page_no_more_articles', 'editContent')
);
array_insert($GLOBALS['TL_DCA']['tl_page']['list']['operations'], 1, array
(
    'editheader' => array
    (
        'label'               => &$GLOBALS['TL_LANG']['tl_form']['editheader'],
        'href'                => 'act=edit',
        'icon'                => 'header.gif',
        //'button_callback'     => array('tl_page', 'editHeader'),
        'attributes'          => 'class="edit-header"'
    ),
));
unset($GLOBALS['TL_DCA']['tl_page']['list']['operations']['articles']);

class tl_page_no_more_articles extends Backend
{
    /**
     * Generate an "edit content" button and return it as string
     */
    public function editContent($row, $href, $label, $title, $icon)
    {
        //if (!$this->User->hasAccess('article', 'modules'))
        //{
        //    return '';
        //}

        return ($row['type'] == 'regular' || $row['type'] == 'error_403' || $row['type'] == 'error_404') ? '<a href="' . $this->addToUrl($href.'&amp;id='.$row['id']) . '" title="'.specialchars($title).'">'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }
}
