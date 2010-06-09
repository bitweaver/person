<?php
/**
 * $Header$
 */
global $gBitInstaller;

$infoHash = array(
	'package' => PERSON_PKG_NAME,
	'version' => str_replace( '.php', '', basename( __FILE__ )),
	'description' => "Initial version of the person package",
	'post_upgrade' => NULL,
);

$gBitInstaller->registerPackageUpgrade( $infoHash, array(
// Empty
)); // registerPackageUpgrade
?>
