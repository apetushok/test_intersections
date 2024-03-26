<?php

namespace App;

use App\Presentation\BookingView;
use App\Repository\BookingRepository;
use App\Services\BookingService;
use PDOException;
use Exception;

class App {

	public function run(): void {
		$this->bootstrap();
	}

	private function bootstrap() {
		// Load configuration
		// Set up autoloading
		// Initialize services and dependencies
		// Any other initialization tasks

		$config = require_once 'Config/db.php';

		try {
			$pdo = Database::getInstance(
				$config[ 'db' ][ 'dsn' ],
				$config[ 'db' ][ 'username' ],
				$config[ 'db' ][ 'password' ]
			);
			$bookingRepo = new BookingRepository( $pdo );
			$bookingService = new BookingService( $bookingRepo );
		} catch ( PDOException $e) {
			http_response_code( 500 );
			echo 'Db error: ' . $e->getMessage(); // TODO remove for prod and add logs instead
			exit();
		} catch ( Exception $e ) {
			http_response_code( 500 );
			echo 'Error: ' . $e->getMessage(); // TODO remove for prod and add logs instead
			exit();
		}

		$router = new Router();

		$router->addRoute( 'GET', '/', function () {
			echo "Home Page";
		} );

		$router->addRoute( 'GET', '/conflicting-bookings', function () use ( $bookingService ) {
			try {
				$bookings = $bookingService->getAllTimeLapseBookings( (string)$_GET[ 'date' ] );
				BookingView::displayAllBookingsView( $bookings, (string)$_GET[ 'date' ] );
			} catch ( \Throwable $e ){
				echo $e->getMessage(); // TODO remove for prod and add logs instead
			}
		} );

		$method = $_SERVER['REQUEST_METHOD'];
		$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		$router->dispatch( $method, $path );
	}
}