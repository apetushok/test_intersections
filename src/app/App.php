<?php

namespace App;

use App\Presentation\BookingView;
use App\Repository\BookingRepository;
use App\Services\BookingService;

class App {

	public function run(): void {
		$this->bootstrap();
	}

	private function bootstrap() {
		// Load configuration
		// Set up autoloading
		// Initialize services and dependencies
		// Any other initialization tasks

		$dsn = 'mysql:host=mysql;dbname=your_database';
		$username = 'root';
		$password = 'your_root_password';

		$pdo = Database::getInstance( $dsn, $username, $password );
		$bookingRepo = new BookingRepository( $pdo );
		$bookingService = new BookingService( $bookingRepo );

		$router = new Router();

		$router->addRoute( 'GET', '/', function () {
			echo "Home Page";
		} );

		$router->addRoute( 'GET', '/conflicting-bookings', function () use ( $bookingService ) {
			try {
				$bookings = $bookingService->getAllTimeLapseBookings( (string)$_GET[ 'date' ] );
				BookingView::displayAllBookingsView( $bookings ); //TODO use twig or something else
			} catch ( \Throwable $e ){
				echo $e->getMessage();
				//TODO log errors
			}
		} );

		$method = $_SERVER['REQUEST_METHOD'];
		$path = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		$router->dispatch( $method, $path );
	}
}