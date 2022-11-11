<?php

// code marker
use Xmf\Jwt\TokenFactory;
use Xmf\Jwt\TokenReader;
use Xmf\Module\Helper;
use Xmf\Request;

$path = dirname(dirname(__DIR__));
require_once $path . '/mainfile.php';

$GLOBALS['xoopsLogger']->activated = false;
error_reporting(E_ALL);

include __DIR__ . '/include/common.php';

define('PROTECTOR_SKIP_DOS_CHECK', 1);

$sessionHelper = new Helper\Session();

header('Content-Type: application/json', true, 200);
$jsonFlags = JSON_NUMERIC_CHECK;
if (PHP_VERSION_ID >= 50400) {
	$jsonFlags |= JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
}
$selarticle_arr['id'] = 0;
if ($sessionHelper->get('selectionarticle') != false){
	$selarticle  = $articleHandler->get($sessionHelper->get('selectionarticle'));
	if (!empty($selarticle)) {
		$selarticle_arr['id']          = $selarticle->getVar('article_id');
		$selarticle_arr['name']        = $selarticle->getVar('article_name');
		$selarticle_arr['reference']   = $selarticle->getVar('article_reference');
		$selarticle_img            	   = $selarticle->getVar('article_logo');
		if ($selarticle_img == ''){
			$selarticle_arr['logo']    = $url_logo_article . 'no-image.png';
		} else {
			$selarticle_arr['logo']    = $url_logo_article . $selarticle_img;
		}
		echo json_encode($selarticle_arr, $jsonFlags);
		exit;
	}
}
echo json_encode($selarticle_arr, $jsonFlags);
exit;
