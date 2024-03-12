<?php

namespace App\Services;

use App\DateHelper;
use App\Repository\BookingRepositoryInterface;

class BookingService {
	public function __construct(
		private BookingRepositoryInterface $bookingRepository
	) {
	}

	public function getAllTimeLapseBookings( string $bookingData ): array {
		$dateTime = DateHelper::stringToDateTime( $bookingData );
		return $this->bookingRepository->findAllTimeLapseBookings( $dateTime );
	}

}

