<?php
// $Header: /cvsroot/bitweaver/_bit_person/BitPerson.php,v 1.3 2009/11/17 15:10:42 dansut Exp $
/**
 * BitPerson is an object designed to contain and allow the manipulation of a
 * person's contact and other personal details 
 *
 * date created 2009/3/16
 * @author Daniel Sutcliffe <dan@lrcnh.com>
 * @version $Revision: 1.3 $
 * @class BitPerson
 */

require_once(LIBERTYFORM_PKG_PATH.'LibertyForm.php');
require_once(ADDRESS_PKG_PATH.'BitAddress.php');

define('BITPERSON_CONTENT_TYPE_GUID', 'bitperson'); // Unique identifier for the object with BW

class BitPerson extends LibertyForm {
	const CONTENT_TYPE_GUID = BITPERSON_CONTENT_TYPE_GUID;
	const DATA_TBL = 'person_data';
	const ALTNAME_TBL = 'person_altname';
	const ADDRESS_TBL = 'person_address';
	const EMAIL_TBL = 'person_email';
	const PHONE_TBL = 'person_phone';
	protected static $mTables = array(
		self::DATA_TBL => "
			person_id I4 PRIMARY,
			content_id I4,
			name_last C(64),
			name_1sts C(128),
			name_title C(32),
			name_suffix C(32),
			gender C(1),
			date_born D,
			citizenship I4,
			contact_id I4,
			altname_1_id I4,
			address_1_id I4,
			email_1_id I4,
			phone_1_id I4",
		self::ALTNAME_TBL => "
			altname_id I4 PRIMARY,
			person_id I4,
			text C(64),
			type C(64),
			note C(128)",
		self::EMAIL_TBL => "
			email_id I4 PRIMARY,
			person_id I4,
			text C(64),
			type C(64),
			note C(128)",
		self::PHONE_TBL => "
			phone_id I4 PRIMARY,
			person_id I4,
			text C(64),
			type C(64),
			note C(128)",
		self::ADDRESS_TBL => "
			address_id I4,
			person_id I4,
			active C(1)",
		);
	const DATA_TBL_SEQ = 'person_data_id_seq';
	const ALTNAME_TBL_SEQ = 'person_altname_id_seq';
	const EMAIL_TBL_SEQ = 'person_email_id_seq';
	const PHONE_TBL_SEQ = 'person_phone_id_seq';
	protected static $mSequences = array(
		self::DATA_TBL_SEQ => array('start' => 1),
		self::ALTNAME_TBL_SEQ => array('start' => 1),
		self::EMAIL_TBL_SEQ => array('start' => 1),
		self::PHONE_TBL_SEQ => array('start' => 1),
		);

// {{{ ---- public functions ----
	// {{{ __construct()
	/**
	 * @param int $pId database Id of exiting object of this type
	 * @param int $pContentId database Id of existing LibertyContent object
	 */
	function __construct($pId=NULL, $pContentId=NULL) {
		$this->mContentTypeGuid = self::CONTENT_TYPE_GUID;
		$this->registerContentType(self::CONTENT_TYPE_GUID, array(
			'content_type_guid'   => self::CONTENT_TYPE_GUID,
			'content_description' => 'Bitweaver person data',
			'handler_class'       => 'BitPerson',
			'handler_package'     => 'person',
			'handler_file'        => 'BitPerson.php',
			'maintainer_url'      => 'http://www.lrcnh.com/'
		));
		// Permission setup
		$this->mViewContentPerm    = 'p_person_view';
		$this->mCreateContentPerm  = 'p_person_create';
		$this->mUpdateContentPerm  = 'p_person_update';
		$this->mAdminContentPerm   = 'p_person_admin';
		$this->mExpungeContentPerm = 'p_person_expunge';

		// Selectable Citizenship/Country from defined list
		$country_options = @BitAddressCountry::getPossibles('country_name', TRUE);
		$country_options[0] = "Unknown"; // Unknown entry is not stored in the DB
		ksort($country_options);

		$altname_fields = array(
			"altname_id" => array(
				"type" => "hidden",
			),
			"type" => array(
				"description" => "Type",
				"type" => "options",
				"options" => NULL, // Set up only when needed in getFields()
				"required" => TRUE,
				"maxlen" => 16,
			),
			"text" => array(
				"description" => "Name",
				"type" => "text",
				"required" => TRUE,
				"maxlen" => 32,
			),
			"note" => array(
				"description" => "Notes",
				"type" => "text",
				"maxlen" => 32,
			),
			"altname_1_id" => array(
				"description" => "Preferred",
				"type" => "radio",
			),
			"remove" => array(
				"description" => "Remove",
				"type" => "remove",
			),
		);

		$email_fields = array(
			"email_id" => array(
				"type" => "hidden",
			),
			"type" => array(
				"description" => "Type",
				"type" => "options",
				"options" => NULL, // Set up only when needed in getFields()
				"required" => TRUE,
				"maxlen" => 16,
			),
			"text" => array(
				"description" => "Email address",
				"type" => "text",
				"required" => TRUE,
				"maxlen" => 32,
			),
			"note" => array(
				"description" => "Notes",
				"type" => "text",
				"maxlen" => 32,
			),
			"email_1_id" => array(
				"description" => "Preferred",
				"type" => "radio",
				"required" => TRUE,
			),
			"remove" => array(
				"description" => "Remove",
				"type" => "remove",
			),
		);

		$phone_fields = array(
			"phone_id" => array(
				"type" => "hidden",
			),
			"type" => array(
				"description" => "Type",
				"type" => "options",
				"options" => NULL, // Set up only when needed in getFields()
				"required" => TRUE,
				"maxlen" => 16,
			),
			"text" => array(
				"description" => "Phone Number",
				"type" => "text",
				"required" => TRUE,
				"maxlen" => 32,
			),
			"note" => array(
				"description" => "Notes",
				"type" => "text",
				"maxlen" => 32,
			),
			"phone_1_id" => array(
				"description" => "Preferred",
				"type" => "radio",
				"required" => TRUE,
			),
			"remove" => array(
				"description" => "Remove",
				"type" => "remove",
			),
		);

		$address_fields = array(
			"address_id" => array(
				"description" => "Address",
				"type" => "options",
				"options" => NULL, // Set up only when needed in getFields()
				"required" => TRUE,
				"shownullopt" => TRUE,
				"createonly" => TRUE,
			),
			"active" => array(
				"description" => "Active",
				"type" => "checkbox",
				"defval" => "y"
			),
			"address_1_id" => array(
				"description" => "Preferred",
				"type" => "radio",
				"required" => TRUE,
			),
			"remove" => array(
				"description" => "Remove",
				"type" => "remove",
			),
		);

		$this->mFields = array(
			"name_title" => array(
				"description" => "Title",
				"type" => "options",
				"options" => array(""=>"<none>", "Mr"=>"Mr", "Mrs"=>"Mrs", "Ms"=>"Ms", "Miss"=>"Miss"),
			),
			"name_1sts" => array(
				"description" => "First Names",
				"maxlen" => 72,
				"required" => TRUE,
				"helptext" => "Persons legal first or forenames, used on passport, birth certificate, etc.",
			),
			"name_last" => array(
				"description" => "Last Name",
				"maxlen" => 64,
				"required" => TRUE,
				"helptext" => "Persons legal last or surname, used on passport, birth certificate, etc.",
			),
			"name_suffix" => array(
				"description" => "Name Suffix",
				"maxlen" => 32,
				"helptext" => "Any suffix text a person may have to there name, eg. Jr/Sr/II/III.",
			),
			self::ALTNAME_TBL => array(
				"description" => "Alternate names",
				"type" => "multiple",
				"fields" => $altname_fields,
				"idfield" => "altname_id",
				"sequence" => self::ALTNAME_TBL_SEQ,
				"helptext" => "Other names the person might be known as, or have been known as.",
			),
			"gender" => array(
				"description" => "Gender",
				"type" => "radios",
				"required" => TRUE,
				"options" => array("M"=>"Male", "F"=>"Female"),
				"helptext" => "Sex of the person.",
			),
			"date_born" => array(
				"description" => "Birth Date",
				"type" => "date",
				"typopt" => "past",
				"defval" => strtotime("-30 years"),
				"required" => TRUE,
				"helptext" => "Date the person was born.",
			),
			"citizenship" => array(
				"description" => "Citizenship",
				"type" => "options",
				"options" => &$country_options,
				"helptext" => "Country the person is a citizen of, for Visa purposes.",
			),
			self::EMAIL_TBL => array(
				"description" => "Email Addresses",
				"type" => "multiple",
				"fields" => $email_fields,
				"idfield" => "email_id",
				"sequence" => self::EMAIL_TBL_SEQ,
				"helptext" => "Internet email addresses the person can be reached at",
			),
			self::PHONE_TBL => array(
				"description" => "Telephone Numbers",
				"type" => "multiple",
				"fields" => $phone_fields,
				"idfield" => "phone_id",
				"sequence" => self::PHONE_TBL_SEQ,
				"helptext" => "Numbers that can be used to reach this person",
			),
			self::ADDRESS_TBL => array(
				"description" => "Addresses",
				"type" => "multiple",
				"fields" => $address_fields,
				"idfield" => "address_id",
				"helptext" => "Addresses for this person",
			),
		);

		parent::__construct($pId, $pContentId, 'person', self::DATA_TBL, self::DATA_TBL_SEQ);
	} // }}}

	// {{{ load() get data from the database either by object or libertyContent's id
	/**
	 * If this object constructed with a valid Id then load from the DB
	 * @return boolean TRUE on success, FALSE on failure - mErrors will contain reason for failure
	 */
	public function load() {
		$ret = parent::load();
		if($ret) {
			$tblidnames = array(
				self::ALTNAME_TBL => 'altname_id',
				self::EMAIL_TBL => 'email_id',
				self::PHONE_TBL => 'phone_id',
				self::ADDRESS_TBL => 'address_id');
			$bindVars = array($this->mId);
			foreach($tblidnames as $table => $idfield) {
				$query = "
					SELECT d.`".$idfield."` as `hash_key`, d.*
					FROM `".BIT_DB_PREFIX.$table."` d
					WHERE (d.`person_id` = ?) ";
				$this->mInfo[$table] = $this->mDb->getAssoc($query, $bindVars);
			}
		}
		return $ret;
	}
	// }}} load()

	// {{{ getFields() get the gui form elements to edit and display the data
	/**
	 * @return array List of objects GUI fields
	 */
	public function getFields() {
		parent::getFields();

		$this->mFields[self::ADDRESS_TBL]['fields']['address_id']['options'][0] = "&lt;none&gt;";
		foreach(@BitAddress::getOptions() as $address_id => $address_text) {
			$this->mFields[self::ADDRESS_TBL]['fields']['address_id']['options'][$address_id] = $address_text;
		}
		// Only give options of addresses that haven't already been used
		if(!empty($this->mFields[self::ADDRESS_TBL]['value'])) {
			$this->mFields[self::ADDRESS_TBL]['fields']['address_id']['notopts'] = $this->mFields[self::ADDRESS_TBL]['value'];
		}

		$this->mFields[self::EMAIL_TBL]['fields']['type']['options'] = array(""=>"<none>", "Home"=>"Home", "Work"=>"Work", "Other"=>"Other");
		$this->mFields[self::ALTNAME_TBL]['fields']['type']['options'] = array(""=>"<none>", "Nickname"=>"Nickname", "Maiden"=>"Maiden", "Other"=>"Other");
		$this->mFields[self::PHONE_TBL]['fields']['type']['options'] = array(""=>"<none>", "Work"=>"Work", "Home"=>"Home", "Mobile"=>"Mobile");

		return $this->mFields;
	} // }}} getFields()

	// {{{ getDataShort() retrieve a short string containing at least some of this objects data
	/**
	 * @return string quick summary of the objects data
	 */
	public function getDataShort() {
		$dataHash = array(
			'name_title' => $this->mInfo['name_title'],
			'name_1sts' => $this->mInfo['name_1sts'],
			'name_last' => $this->mInfo['name_last'],
			'name_suffix' => $this->mInfo['name_suffix'],
			);
		if($altname = $this->getAltname()) $dataHash['name_pref'] = $altname;
		return self::formatDataShort($dataHash);
	} // }}} getDataShort()

	// {{{ getAltname() retrieve a string containing this persons preferred alternate name
	/**
	 * @param boolean whether verbose details to be added to string
	 * @return string the email address and perhaps other data
	 */
	public function getAltname($pVerbose=FALSE) {
		return $this->getPreferred('altname', $pVerbose, FALSE); // Don't fallback if no preferred
	} // }}} getAltname()

	// {{{ getEmail() retrieve a string containing this persons preferred email address
	/**
	 * @param boolean whether verbose details to be added to string
	 * @return string the email address and perhaps other data
	 */
	public function getEmail($pVerbose=FALSE) {
		return $this->getPreferred('email', $pVerbose);
	} // }}} getEmail()

	// {{{ getPhone() retrieve a string containing this persons preferred phone#
	/**
	 * @param boolean whether verbose details to be added to string
	 * @return string the phone#
	 */
	public function getPhone($pVerbose=FALSE) {
		return $this->getPreferred('phone', $pVerbose);
	} // }}} getPhone()
// }}} ---- end public functions

// {{{ ---- public static functions ----
// mostly to deal with the structure and set of objects in the DB, not a specific instance
	// {{{ getSchemaTables()
	public static function getSchemaTables() {
		return self::$mTables;
	} // }}} getSchemaTables()

	// {{{ getSchemaSequences()
	public static function getSchemaSequences() {
		return self::$mSequences;
	} // }}} getSchemaSequences()

	// {{{ getList() generate a list of records from content database for use in list page
	/**
	 * @param array $pParamHash
	 * @return array list of objects of this type in DB, sorted and paging dealt with.
	 */
	public static function getList(&$pParamHash) {
		global $gBitSystem;
		// this makes sure parameters used later on are set
		parent::prepGetList($pParamHash);

		$selectSql = $joinSql = $whereSql = '';
		$bindVars = array();
		array_push($bindVars, self::CONTENT_TYPE_GUID);
		parent::getServicesSql('content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars);

		// this will set $find, $sort_mode, $max_records and $offset
		extract($pParamHash);

		if(is_array($find)) {
			$whereSql .= " AND (lc.`title` IN (".implode(',',array_fill(0,count($find),'?')).")) ";
			$bindVars = array_merge($bindVars, $find);
		} elseif(is_string($find)) {
			$whereSql .= " AND (UPPER(lc.`title`) like ?) ";
			$bindVars[] = '%'.strtoupper($find).'%';
		}

		$query = "
			SELECT data.*, lc.`content_id`, lc.`title`, lc.`data`
				$selectSql
			FROM `".BIT_DB_PREFIX.self::DATA_TBL."` data
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON (lc.`content_id` = data.`content_id`)
				$joinSql
			WHERE (lc.`content_type_guid` = ?)
				$whereSql
			ORDER BY ".$gBitSystem->mDb->convertSortmode($sort_mode);
		$result = $gBitSystem->mDb->query($query, $bindVars, $max_records, $offset);
		$ret = array();
		while($res = $result->fetchRow()) {
			$ret[] = $res;
		}
		$query_cant = "
			SELECT COUNT(*)
			FROM `".BIT_DB_PREFIX.self::DATA_TBL."` data
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON (lc.`content_id` = data.`content_id`)
				$joinSql
			WHERE (lc.`content_type_guid` = ?)
				$whereSql";
		$pParamHash["cant"] = $gBitSystem->mDb->getOne($query_cant, $bindVars);

		// add all pagination info to pParamHash
		parent::postGetList($pParamHash);
		return $ret;
	} // }}} getList()

	// {{{ getPossibles() get an array of people
	/**
	 * @param boolean $only18plus - only show cruises which have yet to sale
	 * @return array people with key id as key and array of first and last names for val
	 */
	public static function getPossibles($pOnly18plus=TRUE) {
		global $gBitSystem;
		$whereSql = '';
//		$now = $gBitSystem->getUTCTime();
//		if($pOnly18plus) { Disabled until I can get a handle on date time handling
//			$whereSql = " WHERE (d.`date_born` > $now) ";
//		}
		$ret = $gBitSystem->mDb->getAssoc("
			SELECT d.`person_id` AS `hash_key`, d.`name_last`, d.`name_1sts`
			FROM `".BIT_DB_PREFIX.self::DATA_TBL."` d
			$whereSql
			ORDER BY `hash_key`");
		return $ret;
	} // }}} getPossibles()

	// {{{ getQuickData() quick return of this objects basic data
	/**
	 * @param int $pId the identifier for an object of this type
	 * @return array hash of this objects DB fields
	 */
	public static function getQuickData($pId) {
		global $gBitSystem;
		$query = "SELECT * FROM `".BIT_DB_PREFIX.self::DATA_TBL."` WHERE (`person_id` = ?)";
		return $gBitSystem->mDb->getRow($query, array($pId));
	} // }}} getQuickData()

	// {{{ getQuickDisplay() quick disply of object of this type without instantiating
	/**
	 * @param int $pId the identifier for an object of this type
	 * @return string quick summary of object with Id
	 */
	public static function getQuickDisplay($pId) {
		$ret = self::getQuickData($pId);
		return ($ret ? self::formatDataShort($ret) : "Unknown Person");
	} // }}} getQuickDisplay()

	// {{{ formatDataShort() given an array of fields create a short formatted display string
	/**
	 * @param array object fields,
	 * @return string quick summary of the data from given fields
	 */
	public static function formatDataShort($pDataHash) {
		$display = "";
		if(isset($pDataHash['name_title']) && !empty($pDataHash['name_title'])) {
			$display .= trim($pDataHash['name_title']);
		}
		if(isset($pDataHash['name_pref']) && !empty($pDataHash['name_pref'])) {
			if(!empty($display)) $display .= " ";
			$display .= "(".trim($pDataHash['name_pref']).")";
		}
		if(isset($pDataHash['name_1sts']) && !empty($pDataHash['name_1sts'])) {
			if(!empty($display)) $display .= " ";
			$display .= trim($pDataHash['name_1sts']);
		}
		if(isset($pDataHash['name_last']) && !empty($pDataHash['name_last'])) {
			if(!empty($display)) $display .= " ";
			$display .= trim($pDataHash['name_last']);
		}
		if(isset($pDataHash['name_suffix']) && !empty($pDataHash['name_suffix'])) {
			if(!empty($display)) $display .= " ";
			$display .= trim($pDataHash['name_suffix']);
		}
		return $display;
	} // }}} formatDataShort()
// }}} ---- end public static functions ----

// {{{ ---- protected functions ----
	// {{{ getPreferred() retrieve the preferred item of one of persons sub table fields
	/**
	 * @param string base name of preferred field, currently 'email', 'altname', & 'phone' valid
	 * @param boolean whether verbose details to be added to string
	 * @param boolean whether to fallback to first item if no preferred item
	 * @return string the phone#
	 */
	protected function getPreferred($pName, $pVerbose, $pFallback1st=TRUE) {
		if(!array_key_exists($pName.'_1_id', $this->mInfo)) return "** Error ".$pName." invalid **";
		$pref_txt = '';
		if(($id = $this->mInfo[$pName.'_1_id']) && isset($this->mInfo['person_'.$pName][$id]) ||
		   ($pFallback1st && ($id = key($this->mInfo['person_'.$pName])))) {
			$pref_txt = $this->mInfo['person_'.$pName][$id]['text'];
			if($pVerbose && !empty($this->mInfo['person_'.$pName][$id]['type'])) {
				$pref_txt .= ' ('.$this->mInfo['person_'.$pName][$id]['type'].')';
			}
		}
		return $pref_txt;
	} // }}} getPreferred()
// }}} ---- end protected functions ----

} // BitPerson class

/* vim: :set fdm=marker : */
?>
