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
     */
    public function __construct($caption, $itemid = 0)
    {

		include __DIR__ . '/../include/common.php';
		xoops_loadLanguage('main', 'xmarticle');

        $sessionHelper = new \Xmf\Module\Helper\Session('xmarticle');
		if ($itemid != 0){
			$sessionHelper->set('selectionarticle', $itemid);
		} else {
			$sessionHelper->del('selectionarticle');
		}

		parent::__construct($caption, '<br>');
		if ($itemid != 0){
			$this->addElement(new XoopsFormLabel('', XmarticleUtility::getArticleName($itemid, true, true)));
		}
		// add article
		$payload = array(
            'aud' => 'articleajax.php',
            'cat' => '',
            'uid' => (is_object($GLOBALS['xoopsUser'])) ? $GLOBALS['xoopsUser']->uid() : 0
        );
		$jwt = \Xmf\Jwt\TokenFactory::build('article', $payload, 60*10); // token good for 10 minutes
		$add_text = "<script>
		setInterval(function getArticle()
		{
			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(this.readyState == 4 && this.status == 200)
				{
					let datas = xhttp.response;
					articleId =  datas['id'];
					if(articleId != 0)
					{
						document.getElementById('articleName').innerHTML = datas['name'] + '(' + datas['reference'] + ')';
						document.getElementById('articleLogo').src = datas['logo'];
						document.getElementById('addArticle').style.display = 'none';
					} else {
						document.getElementById('addArticle').style.display = 'block';
					}
				}
			};
			xhttp.open('GET', '" . XOOPS_URL . "/modules/xmarticle/articleajax.php?Authorization=" . $jwt . "', true);
			xhttp.responseType = 'json';
			xhttp.send();
		}, 1000);
		</script>";
		$add_text .= "<span class='font-weight-bold' id='articleName'></span>";
		$add_text .= "<br><img src='' id='articleLogo' alt='' style='max-width:100px'>";
		$add_text .= "<br>";
		$add_text .= "<button type='button' class='btn btn-secondary btn-sm' id='addArticle' onclick='openWithSelfMain(\"" . XOOPS_URL . "/modules/xmarticle/articlemanager.php\",\"articlemanager\",400,430);' onmouseover='style.cursor=\"hand\"' title='" . _MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD . "'>";
		$add_text .= "<span class='fa fa-file' aria-hidden='true'></span>";
		$add_text .= "<small> " . _MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD . "</small>";
		$add_text .= "</button>";
		$this->addElement(new XoopsFormLabel('', $add_text));
    }
}