<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_person/admin/upgrades/0.1.0.php,v 1.1 2009/09/23 15:20:22 spiderr Exp $
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
