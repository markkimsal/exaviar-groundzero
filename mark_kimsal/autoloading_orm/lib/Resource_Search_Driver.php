<?php

/**
 * The storage driver needs to interface Evr Models and 
 * external storage requirements.  It needs to know how
 * both sides work.  It has methods that work with 
 * each face.
 */
interface Evr_Resource_Search_Driver {

	public function indexAdd($object);

	public function indexDel($object, $id);

	public function search($object, &$list, $where, $limit=null);

	public function indexUpdate($object, $id);

	public function getStorageKind($object);

	public function getIdName($object);

	public function createNew($object);
}

/**
 * Implement standard behaviors between any driver and 
 * the object, but not driver specific ones
 */
abstract class Evr_Resource_Search_Driver_Default implements Evr_Resource_Search_Driver {

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
class Evr_Resource_Search_Driver_Dummy extends Evr_Resource_Search_Driver_Default {

	public function indexAdd($object) {
		echo "[Search-Dummy]: Will index an object of type ".$this->getStorageKind($object).".\n";
	}

	public function indexDel($object, $id) {
		echo "[Search-Dummy]: Will remove from the index an object of type ".$this->getStorageKind($object)." and ID ".$id.".\n";
	}

	public function search($object, &$list, $where, $limit=null) {
		echo "[Search-Dummy]: Will search the index for objects of type ".$this->getStorageKind($object)." where ".$where;
		if (is_array($limit)) {
			echo " and limiting to ".$limit['count']." results";
		}
		echo ".\n";
	}

	public function indexUpdate($object, $id) {
		echo "[Search-Dummy]: Will save an existing  object of type ".get_class($object).".\n ";
	}
}

/**
 * Index in SOLR
 */
class Evr_Resource_Search_Driver_Solr extends Evr_Resource_Search_Driver_Default {

	protected $readRes  = null;
	protected $writeRes = null;

	public function indexAdd($object) {
		echo "[Search-Solr]: Will index an object of type ".$this->getStorageKind($object).".\n";
	}

	public function indexDel($object, $id) {
		echo "[Search-Solr]: Will remove from the index an object of type ".$this->getStorageKind($object)." and ID ".$id.".\n";
	}

	public function search($object, &$list, $where, $limit=null) {
		echo "[Search-Solr]: Will search the index for objects of type ".$this->getStorageKind($object)." where ".$where;
		if (is_array($limit)) {
			echo " and limiting to ".$limit['count']." results";
		}
		echo ".\n";
	}

	public function indexUpdate($object, $id) {
		echo "[Search-Solr]: Will save an existing  object of type ".get_class($object).".\n ";
	}
}
