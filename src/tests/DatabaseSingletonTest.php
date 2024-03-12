<?php

use App\Database;
use PHPUnit\Framework\TestCase;

class DatabaseSingletonTest extends TestCase {

	public function testSingletonInstance() {
		$dsn = 'mysql:host=mysql;dbname=your_database';
		$username = 'root';
		$password = 'your_root_password';

		$instance1 = Database::getInstance( $dsn, $username, $password );
		$instance2 = Database::getInstance( $dsn, $username, $password );

		$this->assertSame( $instance1, $instance2 );
	}

}
