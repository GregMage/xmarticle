<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmarticle module
 *
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * A simple text field
 */
class XmarticleFormArticle extends XoopsFormElementTray
{
	/**
     * Constructor
     *
     * @param string $modulename   name of module
     */
    public function __construct($caption, $itemid = 0)
    {
        
		include __DIR__ . '/../include/common.php';
		xoops_loadLanguage('main', 'xmarticle');
        
        $sessionHelper = new \Xmf\Module\Helper\Session('xmarticle');
        $sessionHelper->del('selectionarticle');

		parent::__construct($caption, '<br>');
		if ($itemid != 0){
			$this->addElement(new XoopsFormLabel('', XmarticleUtility::getArticleName($itemid, true, true)));
		}
		// add article
		$add_text = "<br>";
		$add_text .= "<button type='button' class='btn btn-default btn-sm' onclick='openWithSelfMain(\"" . XOOPS_URL . "/modules/xmarticle/articlemanager.php\",\"articlemanager\",400,430);' onmouseover='style.cursor=\"hand\"' title='" . _MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD . "'>";
		$add_text .= "<span class='fa fa-file' aria-hidden='true'></span>";
		$add_text .= "<small> " . _MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD . "</small>";
		$add_text .= "</button>";
		$this->addElement(new XoopsFormLabel('', $add_text));
    }
}
