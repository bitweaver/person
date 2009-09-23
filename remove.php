<?php
/**
 * $Id: remove.php,v 1.1 2009/09/23 15:20:22 spiderr Exp $
 * @package person
 */

// required setup
require_once('../bit_setup_inc.php');
include_once(PERSON_PKG_PATH.'lookup_inc.php');

$gBitSystem->verifyPackage('person');

if(!$gContent->isValid()) {
	$gBitSystem->fatalError("No person indicated");
}

$gContent->verifyExpungePermission();

if(isset($_REQUEST["confirm"])) {
	if($gContent->expunge()) {
		bit_redirect(PERSON_PKG_URL);
	} else {
		vd($gContent->mErrors);
	}
}

$gBitSystem->setBrowserTitle(tra('Confirm delete of: ').$gContent->getTitle());
$formHash['remove'] = TRUE;
$formHash['person_id'] = $_REQUEST['person_id'];
$msgHash = array(
	'label' => tra('Delete Person'),
	'confirm_item' => $gContent->getTitle(),
	'warning' => tra('This person will be completely deleted.<br />This cannot be undone!'),
);
$gBitSystem->confirmDialog($formHash, $msgHash);

?>
