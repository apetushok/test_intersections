<?php

namespace App\Repository;

use App\Model\Booking;
use App\Model\Patient;
use PDO;
use DateTime;

class BookingRepository implements BookingRepositoryInterface {
	public function __construct( private PDO $pdo )  {
	}

	/**
	 * @return array [Booking]
	 */
	public function findAllTimeLapseBookings( DateTime $bookingDate ): array {
		$sql = "SELECT DISTINCT b1.*, p.*
				FROM booking b1
				JOIN booking b2 ON b1.id != b2.id
				JOIN patient p ON b1.patient_id = p.id
				WHERE DATE(b1.booking_date) = ? 
				  AND b1.booking_date = b2.booking_date
				  AND (
					(b1.start_time < b2.end_time AND b1.end_time > b2.start_time)
					OR (b2.start_time < b1.end_time AND b2.end_time > b1.start_time)
				  )
				ORDER BY b1.start_time;";

		$stmt = $this->pdo->prepare( $sql );
		$bookingDate = $bookingDate->format( 'Y-m-d' );
		$stmt->execute( [ $bookingDate ] );

		$bookings = [];

		while ($bookingData = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$bookings[] = new Booking(
				$bookingData['id'],
				new Patient(
					$bookingData['patient_id'],
					$bookingData['name'],
					$bookingData['mobile_phone']
				),
				new DateTime( $bookingData['booking_date'] ),
				new DateTime( $bookingData['start_time'] ),
				new DateTime( $bookingData['end_time'] ),
				$bookingData['comment']
			);
		}

		return $bookings;
	}

}
