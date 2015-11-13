<?php
/**
 * Wraps around a TreedropdownField to add ability for temporary
 * switching of subsite sessions.
 * 
 * @package subsites
 */
class SubsitesTreeDropdownField extends TreeDropdownField {

	private static $allowed_actions = array(
		'tree'
	);

	/**
	 * ID of selected subsite
	 *
	 * @var int
	 */
	protected $subsiteID = 0;

	/**
	 * Custom CSS classes for this field
	 *
	 * @var array
	 */
	protected $extraClasses = array('SubsitesTreeDropdownField');
	
	public function Field($properties = array()) {
		Requirements::javascript('subsites/javascript/SubsitesTreeDropdownField.js');
		return parent::Field($properties);
	}

	/**
	 * Set this field to the given subsite ID
	 *
	 * @param int $id
	 */
	public function setSubsiteID($id) {
		$this->subsiteID = $id;
	}

	/**
	 * Get the subsite ID this field is assigned to
	 *
	 * @return int
	 */
	public function getSubsiteID() {
		return $this->subsiteID;
	}

	/**
	 * Determine the children for the given subtree
	 *
	 * @param SS_HTTPRequest $request
	 * @return string
	 */
	public function tree(SS_HTTPRequest $request) {
		// Check subsite to request from
		$subsiteField = $this->getName() . '_SubsiteID';
		$subsiteID = $request->requestVar($subsiteField);
		if(!isset($subsiteID)) {
			$subsiteID = $this->getSubsiteID();
		}
		if(!isset($subsiteID)) {
			$subsiteID = Session::get('SubsiteID');
		}

		// Get tree for specified subsite
		$oldSubsiteID = Session::get('SubsiteID');
		Session::set('SubsiteID', $subsiteID);
		$results = parent::tree($request);
		Session::set('SubsiteID', $oldSubsiteID);
		
		return $results;
	}
}