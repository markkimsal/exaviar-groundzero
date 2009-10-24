<?php
/**
 * The purpose of this example is to explore the possiblities 
 * of dynamically loading any ORM at runtime.  The complexities 
 * of using a DI manager for this should be minimal as the 
 * driver will probably be the same for the entire duration 
 * of a request.
 *
 * This example demonstrates a data model that interacts with 
 * two resource drivers, a storage driver and a search index driver.
 */

require ('lib/Resource_Model.php');
require ('lib/Resource_Loader.php');

//plain objects will not be searchable
$x = new Evr_Resource_Model();
$x->load(1);
$x->save();

//easy enough to index objects in solr/lucene
$y = new Evr_Resource_Model();
$y->_searchable = TRUE;
$y->load(1);
$y->save();


//not important
function evr_setting($key) {
	if ($key == 'res_storage_driver') {
		//return 'Evr_Resource_Storage_Driver_Mysql';
		return 'Evr_Resource_Storage_Driver_Dummy';
	}
	if ($key == 'res_search_driver') {
		//return 'Evr_Resource_Search_Driver_Cassandra';
		return 'Evr_Resource_Search_Driver_Dummy';
	}
}

