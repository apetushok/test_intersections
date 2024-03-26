<?php

namespace App;

use PDO;

class Database {
	private static $instance;
	private $pdo;

	private function __construct( $dsn, $username, $password ) {
		$this->pdo = new PDO( $dsn, $username, $password );
		$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}

	public static function getInstance( $dsn, $username, $password ) {
		if ( !self::$instance ) {
			self::$instance = new self( $dsn, $username, $password );
		}
		return self::$instance->pdo;
	}

	public function __clone() {}

	public function __wakeup() {}
}