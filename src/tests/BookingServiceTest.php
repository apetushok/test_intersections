<?php

use App\Model\Booking;
use PHPUnit\Framework\TestCase;
use App\Model\Patient;
use App\Services\BookingService;
use App\Repository\BookingRepository;

class BookingServiceTest extends TestCase {

	protected $bookingRepositoryMock;

	protected function setUp(): void {
		$this->bookingRepositoryMock = $this->getMockBuilder( BookingRepository::class )
			->disableOriginalConstructor()
			->getMock();
	}

	public function testReturnBookingArray() {
		$this->bookingRepositoryMock->expects( $this->once() )
			->method( 'findAllTimeLapseBookings' )
			->willReturn( [ new Booking(
				1,
				new Patient( 2, 'Test patient', '111222333'),
				new DateTime( '2024-03-10' ),
				new DateTime( '10:00' ),
				new DateTime( '11:00' ),
				'comment'
			) ] );

		$bookingService = new BookingService( $this->bookingRepositoryMock );

		$result = $bookingService->getAllTimeLapseBookings( '2024-03-10' );
		$booking = $result[ 0 ];

		$this->assertInstanceOf( Booking::class, $booking );
		$this->assertEquals( 1, $booking->getId() );
		$this->assertEquals( 'comment', $booking->getComment() );
	}

	public function testThrowExceptionForIncorrectDate() {
		$bookingService = new BookingService( $this->bookingRepositoryMock );

		$this->expectException( InvalidArgumentException::class );
		$bookingService->getAllTimeLapseBookings( '100001' );
	}

}
