<?php

namespace App\Repository;

use App\Model\Booking;
use PDO;
use DateTime;

class BookingRepository implements BookingRepositoryInterface {
	public function __construct( private PDO $pdo )  {
	}

	/**
	 * @return array [Booking]
	 */
	public function findAllTimeLapseBookings( DateTime $bookingDate ): array {
		$sql = "SELECT b1.*
                FROM booking b1
                JOIN booking b2 ON b1.end_time > b2.start_time
                               AND b1.start_time < b2.end_time
                               AND b1.id != b2.id
                WHERE DATE(b1.booking_date) = ?";

		$stmt = $this->pdo->prepare( $sql );
		$bookingDate = $bookingDate->format( 'Y-m-d' );
		$stmt->execute( [ $bookingDate ] );

		$bookings = [];

		while ($bookingData = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$bookings[] = new Booking(
				$bookingData['id'],
				$bookingData['patient_id'],
				new DateTime( $bookingData['booking_date'] ),
				new DateTime( $bookingData['start_time'] ),
				new DateTime( $bookingData['end_time'] ),
				$bookingData['comment']
			);
		}

		return $bookings;
	}

}
