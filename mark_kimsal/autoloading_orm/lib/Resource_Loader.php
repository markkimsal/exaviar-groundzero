<?php

include ('./phemto/phemto.php');

/**
 * Dependency Injector for ORM
 */
class Evr_Resource_Loader {

	static $phemto = null;

	/**
	 * Load a configured ORM 
	 */
	public static function loadMapper() {
		$phemto = self::getDi();
		return $phemto->create('Evr_Resource_Storage_Driver');
	}

	/**
	 * Load a configured search indexer
	 */
	public static function loadIndexer() {
		$phemto = self::getDi();
		return $phemto->create('Evr_Resource_Search_Driver');
	}


	public static function getDi() {
		if (Evr_Resource_Loader::$phemto === NULL) {
			Evr_Resource_Loader::$phemto = new Phemto();
			Evr_Resource_Loader::buildPhemto();
		}
		return Evr_Resource_Loader::$phemto;
	}

	/**
	 * Apply a configuration file to the Dependency Injector
	 */
	public static function buildPhemto() {
		//run through a configuration file to 
		//apply classnames to DI
		require ('Resource_Storage_Driver.php');
		require ('Resource_Search_Driver.php');

		//scope
		$p = Evr_Resource_Loader::$phemto;
		if (function_exists('evr_setting')) {
			$storageDriver = evr_setting('res_storage_driver');
			$searchDriver  = evr_setting('res_search_driver');
		} else {
			//hardcoded examples
			//$driver = 'Evr_Resource_Storage_Driver_Mysql';
			$storageDriver = 'Evr_Resource_Storage_Driver_Dummy';
			$searchDriver  = 'Evr_Resource_Search_Driver_Dummy';
		}

		//this is specifying 'mysql' for any required 'driver' call
		$p->willUse($storageDriver);
		$p->willUse($searchDriver);
	}
}
