<?php

/**
 * Gateway to an ORM.  Evr_Resource_Storage_Driver knows 
 * how to interact with Evr_Resource_Models.  If you 
 * want to easily save your data, sub-class Evr_Resource_Model
 */
class Evr_Resource_Model {

	public $_tableName  = '';
	public $_id         = -1;
	public $_isNew      = TRUE;
	public $_searchable = FALSE;

	public function __construct($id=-1) {
		$this->_init();
		if ($id > 0) {
			$this->load($id);
		}
	}

	/**
	 * For extension
	 */
	public function _init() {
	}

	public function load($id=-1) {
		$mapper = Evr_Resource_Loader::loadMapper();
		$mapper->load($this, $id);
	}

	public function save() {
		$mapper = Evr_Resource_Loader::loadMapper();
		$mapper->save($this, $this->getStorageId());
		if ($this->_searchable) {
			$indexer = Evr_Resource_Loader::loadIndexer();
			$indexer->indexAdd($this, $this->getStorageId());
		}
	}

	public function preSave() {
	}

	public function postSave() {
	}

	public function preLoad($id=-1) {
	}

	public function postLoad($id=-1) {
	}

	/**
	 * Return a configured table name, or this class name
	 */
	public function getStorageKind() {
		if ($this->_tableName == '') {
			return strtolower(get_class($this));
		}
		return $this->_tableName;
	}

	/**
	 * return this object's "id"
	 */
	public function getStorageId() {
		return $this->_id;
	}
}
