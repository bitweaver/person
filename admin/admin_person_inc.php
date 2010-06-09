<?php
/**
 * @version $Header$
 * @package person
 */
require_once(PERSON_PKG_PATH.'BitPerson.php');

$pkgname = PERSON_PKG_NAME;
$grpname = $pkgname.'_admin';
$gBitSmarty->assign('grpname', $grpname);

// Process the form if some changes have been submitted
if(isset($_REQUEST[$grpname.'_submit'])) LibertyForm::storeConfigs($_REQUEST[$grpname], $pkgname);

$fields = array(
	"list_name_title" => array(
		'description' => 'Title',
		'helptext' => 'Display the personal title.',
		'type' => 'checkbox',
		'value' => $gBitSystem->getConfig($pkgname.'_list_name_title'),
	),
	"list_gender" => array(
		'description' => 'Gender',
		'helptext' => 'Display the gender of the person.',
		'type' => 'checkbox',
		'value' => $gBitSystem->getConfig($pkgname.'_list_gender'),
	),
);
$gBitSmarty->assign('fields', $fields);

?>
