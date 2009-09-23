<?php
global $gBitSystem, $gBitThemes;

$registerHash = array(
	'package_name' => 'person',
	'package_path' => dirname(__FILE__).'/',
	'homeable' => FALSE,
);
$gBitSystem->registerPackage($registerHash);

// If package is active then setup up some stuff for actual package usage
if($gBitSystem->isPackageActive('person')) {
	// If the user has view auth then ...
	if($gBitUser->hasPermission('p_person_view')) {
		// Register the package menu
		$menuHash = array(
			'package_name'  => PERSON_PKG_NAME,
			'index_url'     => PERSON_PKG_URL.'index.php',
			'menu_template' => 'bitpackage:person/menu.tpl',
		);
		$gBitSystem->registerAppMenu($menuHash);
	}

	$gBitThemes->loadCss(PERSON_PKG_PATH.'bit_pkgstyle.css');
}
?>
