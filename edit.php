<?php
// $Header: /cvsroot/bitweaver/_bit_person/edit.php,v 1.3 2010/02/08 21:27:24 wjames5 Exp $

// Initialization
require_once('../kernel/setup_inc.php');

// Is package installed and enabled
$gBitSystem->verifyPackage('person');

require_once(PERSON_PKG_PATH.'lookup_inc.php');

// Now check permissions to access this page
if($gContent->isValid()){
	$gContent->verifyUpdatePermission();
} else {
	$gContent->verifyCreatePermission();
}

// Set up access to edit services needed by Person
$gContent->invokeServices('content_edit_function');

// Check if the page has changed
if(!empty($_REQUEST["save_person"])) {
	// Check if all Request values are delivered, and if not, set them to avoid error messages.
	// This can happen if some features are disabled
	if($gContent->store($_REQUEST['person'])) {
		bit_redirect($gContent->getDisplayUrl());
	} else {
		$gBitSmarty->assign_by_ref('errors', $gContent->mErrors);
	}
}

// Load field attributes
$gBitSmarty->assign_by_ref('fields', $gContent->getFields());

// Display the template
$gBitSystem->display('bitpackage:person/edit.tpl', tra('Person') , array('display_mode' => 'edit'));

?>
