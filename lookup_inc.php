<?php
global $gContent;
require_once(PERSON_PKG_PATH.'BitPerson.php');

// if we already have a gContent, we assume someone else created it for us, and has properly loaded everything up.
if(empty($gContent) || !is_object($gContent) || !$gContent->isValid()) {
	// if person_id supplied, use that
	if(@BitBase::verifyId($_REQUEST['person_id'])) {
		$gContent = new BitPerson($_REQUEST['person_id']);
	} elseif(@BitBase::verifyId($_REQUEST['content_id'])) {
		$gContent = new BitPerson(NULL, $_REQUEST['content_id']);
	} elseif(@BitBase::verifyId($_REQUEST['person']['person_id'])) {
		$gContent = new BitPerson($_REQUEST['person']['person_id']);
	} else { // otherwise create new object
		$gContent = new BitPerson();
	}

	$gContent->load();
	$gBitSmarty->assign_by_ref("gContent", $gContent);
}
?>
