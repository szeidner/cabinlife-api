<?php
class Model {
	protected $db;

	function __construct($controllerName) {

		// connect db
		try {
			$this->db = new PDO(DB_TYPE . ":host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
		} catch (PDOException $e) {
			echo "Oops! " . $e->getMessage();
		}

		$this->_model = get_class($this);
		$this->_table = strtolower($controllerName);
	}
}