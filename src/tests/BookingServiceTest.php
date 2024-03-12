<?php

use App\Model\Booking;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase {

	protected $bookingRepositoryMock;

	protected function setUp(): void {
		$this->bookingRepositoryMock = $this->getMockBuilder( \App\Repository\BookingRepository::class )
			->disableOriginalConstructor()
			->getMock();
	}

	public function testCreateBooking() {
		$this->bookingRepositoryMock->expects( $this->once() )
			->method( 'findAllTimeLapseBookings' )
			->willReturn( [ new Booking(
				1,
				2,
				new DateTime( '2024-03-10' ),
				new DateTime( '10:00' ),
				new DateTime( '11:00' ),
				'comment'
			) ] );

		$bookingService = new \App\Services\BookingService( $this->bookingRepositoryMock );

		$result = $bookingService->getAllTimeLapseBookings( '2024-03-10' );

		$this->assertInstanceOf( \App\Model\Booking::class, $result[ 0 ] );
	}

}
