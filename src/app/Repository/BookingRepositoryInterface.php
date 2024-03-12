<?php

namespace App\Repository;

use DateTime;

interface BookingRepositoryInterface {
	public function findAllTimeLapseBookings(  DateTime $bookingDate ): array;
}