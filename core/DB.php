<?php

require_once __DIR__ . '../includes/config.php';

try {
	$db = new PDO('mysql:host=' . DB_HOST .';dbname=' . DB_NAME_FF . ';charset=utf8mb4', DB_USER, DB_PASS);
	// set the PDO error mode to exception
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

// EOF