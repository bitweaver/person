<?php
// Initialization
require_once('../bit_setup_inc.php');

// Is package installed and enabled
$gBitSystem->verifyPackage('person');

// Check permissions to access this page before even try to get content
$gBitSystem->verifyPermission('p_person_view');

// Attempt to get content if specified, otherwise will just initialise a $gContent
require_once(PERSON_PKG_PATH.'lookup_inc.php');

// Load field attributes
$gBitSmarty->assign_by_ref('fields', $gContent->getFields());

// If there is a person specified by Id, then display just it
if(!empty($_REQUEST['person_id']) || !empty($_REQUEST['content_id'])) {
	if(!$gContent->isValid()) { // If the content failed to load
		$gBitSystem->setHttpStatus(404);
		if(!empty($_REQUEST['person_id'])) { // Specified by person Id
			$gBitSystem->fatalError(tra("The requested data (id=".$_REQUEST['person_id'].") has invalid content."));
		} else { // Specified by content ID
			$gBitSystem->fatalError(tra("The requested content (id=".$_REQUEST['content_id'].") has invalid data."));
		}
	}

	$gContent->verifyViewPermission();

	$gContent->addHit();

	$gBitSystem->display('bitpackage:person/view.tpl', tra('Person'), array('display_mode' => 'display'));

} else { // List the available content
	$list = $gContent->getList($_REQUEST);
	$gBitSmarty->assign_by_ref('list', $list);
	// getList() places all the pagination information in $_REQUEST['listInfo']
	$gBitSmarty->assign_by_ref('listInfo', $_REQUEST['listInfo']);

	$gBitSystem->display('bitpackage:person/list.tpl', tra('Person'), array('display_mode' => 'list'));
}
?>
