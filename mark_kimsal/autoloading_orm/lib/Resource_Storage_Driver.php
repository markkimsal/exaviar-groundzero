<?php

/**
 * The storage driver needs to interface Evr Models and 
 * external storage requirements.  It needs to know how
 * both sides work.  It has methods that work with 
 * each face.
 */
interface Evr_Resource_Storage_Driver {

	public function save($object);

	public function load($object, $id);

	public function find($object, &$list, $where, $limit=null);

	public function update($object, $id);

	public function getStorageKind($object);

	public function getIdName($object);

	public function createNew($object);
}

/**
 * Implement standard behaviors between any driver and 
 * the object, but not driver specific ones
 */
abstract class Evr_Resource_Storage_Driver_Default implements Evr_Resource_Storage_Driver {
	/*
	abstract public function save($object);

	abstract public function load($object, $id);

	abstract public function find($object, &$list, $where, $limit=null);

	abstract public function update($object, $id);
	 */

	public function getStorageKind($object) {
		return $object->getStorageKind();
	}

	public function getIdName($object) {
		return $object->getStorageKind().'_id';
	}

	public function createNew($object) {
		$c = get_class($object);
		return new $c(); 
	}
}


/**
 * Just echo statements
 */
class Evr_Resource_Storage_Driver_Dummy extends Evr_Resource_Storage_Driver_Default {

	public function save($object) {
		echo "[Storage-Dummy]: Will save object of type ".$this->getStorageKind($object).".\n";
	}

	public function load($object, $id) {
		echo "[Storage-Dummy]: Will load object of type ".$this->getStorageKind($object)." and ID ".$id.".\n";
	}

	public function find($object, &$list, $where, $limit=null) {
		echo "[Storage-Dummy]: Will load a list of objects of type ".$this->getStorageKind($object)." where ".$where;
		if (is_array($limit)) {
			echo " and limiting to ".$limit['count']." results";
		}
		echo ".\n";
	}

	public function update($object, $id) {
		echo "[Storage-Dummy]: Will save an existing  object of type ".$this->getStorageKind($object).".\n ";
	}
}

/**
 * Save to Mysql
 */
class Evr_Resource_Storage_Driver_Mysql extends Evr_Resource_Storage_Driver_Default {

	protected $readRes  = null;
	protected $writeRes = null;


	public function save($object) {

		$statementString = 'INSERT INTO `'.$this->getStorageKind($object).'` 
			(`'.$this->getIdName($object).'`)
			VALUES '.$object->getStorageId().')';
		$rst = mysql_query($statementString, $this->writeRes);
		return $rst;

		//instead of returning raw results from raw php drivers, 
		//the result should be mapped to a consistent EVR_STORAGE_RESULT_GOOD/BAD
//		return $this->mapResult($rst);
	}

	public function load($object, $id) {
		echo "[Storage-Mysql]: Will load object of type ".$this->getStorageKind($object)." and ID ".$id.".\n";
	}

	public function find($object, &$list, $where, $limit=null) {
		echo "[Storage-Mysql]: Will load a list of objects of type ".$this->getStorageKind($object)." where ".$where;
		if (is_array($limit)) {
			echo " and limiting to ".$limit['count']." results";
		}
		echo ".\n";
	}

	public function update($object, $id) {
		echo "[Storage-Mysql]: Will save an existing  object of type ".$this->getStorageKind($object).".\n ";
	}
}

/**
 * Use prepared statements
 */
class Evr_Resource_Storage_Driver_PdoMysql extends Evr_Resource_Storage_Driver_Mysql {
}
