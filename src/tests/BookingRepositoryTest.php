<?php

use PHPUnit\Framework\TestCase;
use App\Repository\BookingRepository;
use App\Model\Booking;
use App\Model\Patient;

class BookingRepositoryTest extends TestCase {
	private $pdo;
	private $repository;

	protected function setUp(): void {
		$this->pdo = new PDO( 'mysql:host=mysql;dbname=test_database', 'root', 'your_root_password' );
		$this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->pdo->beginTransaction();
		$this->repository = new BookingRepository( $this->pdo );
	}

	protected function tearDown(): void {
		$this->pdo->rollBack();
	}

	public function testFindExistingTimeLapseBookings(): void {
		$fixtures = file_get_contents(__DIR__ . '/fixtures/with_intersections.sql');
		$this->pdo->exec($fixtures);

		$bookingDate = new DateTime('2024-02-15');
		$bookings = $this->repository->findAllTimeLapseBookings( $bookingDate );

		$this->assertNotEmpty( $bookings );
		$this->assertCount( 5, $bookings );

		$bookingDate = new DateTime('2024-02-17');
		$bookings = $this->repository->findAllTimeLapseBookings( $bookingDate );

		$this->assertNotEmpty( $bookings );
		$this->assertCount( 3, $bookings );
	}

	public function testFindNotExistingTimeLapseBookings(): void {
		$fixtures = file_get_contents(__DIR__ . '/fixtures/without_intersections.sql');
		$this->pdo->exec($fixtures);

		$bookingDate = new DateTime('2024-02-15');
		$bookings = $this->repository->findAllTimeLapseBookings( $bookingDate );

		$this->assertEmpty( $bookings );
	}

	public function testReturnedBookings(): void {
		$fixtures = file_get_contents(__DIR__ . '/fixtures/with_intersections.sql');
		$this->pdo->exec($fixtures);

		$bookingDate = new DateTime('2024-02-15');
		$bookings = $this->repository->findAllTimeLapseBookings( $bookingDate );

		$booking = $bookings[ 0 ];

		$this->assertInstanceOf( Booking::class, $booking );
		$this->assertInstanceOf( Patient::class, $booking->getPatient() );
		$this->assertInstanceOf( DateTime::class, $booking->getBookingDate() );
	}
}
