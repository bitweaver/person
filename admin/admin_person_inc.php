<?php
// $Header: /cvsroot/bitweaver/_bit_person/admin/admin_person_inc.php,v 1.1 2009/09/23 15:20:22 spiderr Exp $

require_once( PERSON_PKG_PATH.'BitPerson.php' );

$formPersonLists = array(
	"person_list_name_title" => array(
		'label' => 'Title',
		'note' => 'Display the personal title.',
	),
	"person_list_gender" => array(
		'label' => 'Gender',
		'note' => 'Display the gender of the person.',
	),
);
$gBitSmarty->assign( 'formPersonLists', $formPersonLists );
$person = new BitPerson();

// Process the form if we've made some changes
if( !empty( $_REQUEST['person'] )) {
	$personToggles = array_merge( $formPersonLists );
	foreach( $personToggles as $item => $data ) {
		simple_set_toggle( $item, PERSON_PKG_NAME );
	}
}

$person_data = $person->getList( $_REQUEST );
$gBitSmarty->assign_by_ref( 'person_data', $person_data);

?>
