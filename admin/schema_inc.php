<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_person/admin/schema_inc.php,v 1.1 2009/09/23 15:20:22 spiderr Exp $
 * @package person
 */
global $gBitInstaller;
require_once(PERSON_PKG_PATH.'BitPerson.php');

$gBitInstaller->registerPackageInfo(PERSON_PKG_NAME, array(
	'description' => "This package is to store and manipulate data about people.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
));

// Get definition of DB tables used by this packages objects.
$tables = array_merge(
	BitPerson::getSchemaTables()
);

foreach(array_keys($tables) AS $tableName) {
	$gBitInstaller->registerSchemaTable(PERSON_PKG_NAME, $tableName, $tables[$tableName]);
}

// $indices = array();
// $gBitInstaller->registerSchemaIndexes(PERSON_PKG_NAME, $indices);

// Sequences
$gBitInstaller->registerSchemaSequences(PERSON_PKG_NAME, // array_merge(
	BitPerson::getSchemaSequences()
//	)
	);

// Schema defaults
// $gBitInstaller->registerSchemaDefault(PERSON_PKG_NAME, array());

// User Permissions
$gBitInstaller->registerUserPermissions(PERSON_PKG_NAME, array(
	array('p_person_admin', 'Can admin person data', 'admin', PERSON_PKG_NAME),
	array('p_person_update', 'Can update any person data', 'editors', PERSON_PKG_NAME),
	array('p_person_create', 'Can create a person data', 'registered', PERSON_PKG_NAME),
	array('p_person_view', 'Can view person data', 'basic', PERSON_PKG_NAME),
	array('p_person_expunge', 'Can remove any person data', 'admin', PERSON_PKG_NAME),
));

// Default Preferences
$gBitInstaller->registerPreferences( PERSON_PKG_NAME, array(
	array(PERSON_PKG_NAME, 'person_default_ordering', 'person_id_desc'),
	array(PERSON_PKG_NAME, 'person_list_name_title', 'y'),
	array(PERSON_PKG_NAME, 'person_list_gender', 'y'),
	array(PERSON_PKG_NAME, 'person_list_description', 'n'),
));

// Version - now use upgrades dir to set package version number.
// $gBitInstaller->registerPackageVersion(PERSON_PKG_NAME, '0.1.0');

// Requirements
$gBitInstaller->registerRequirements(PERSON_PKG_NAME, array(
	'liberty' => array('min' => '2.1.0'),
	'kernel' => array('min' => '2.0.0'),
	'themes' => array('min' => '2.0.0'),
	'languages' => array('min' => '2.0.0'),
	'address' => array('min' => '0.1.0'),
	'libertyform' => array('min' => '0.1.0'),
));
?>
