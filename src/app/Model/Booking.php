<?php

namespace App\Model;

use DateTime;

class Booking {
	public function __construct(
		private int $id,
		private int $patientId,
		private DateTime $bookingDate,
		private DateTime $startTime,
		private DateTime $endTime,
		private string $comment
	) {
	}

	public function getId(): int {
		return $this->id;
	}

	public function setId( int $id ):void {
		$this->id = $id;
	}

	public function getPatientId(): int {
		return $this->patientId;
	}

	public function setPatientId( int $patientId ): void {
		$this->patientId = $patientId;
	}

	public function getBookingDate(): DateTime {
		return $this->bookingDate;
	}

	public function setBookingDate( DateTime $bookingDate ): void {
		$this->bookingDate = $bookingDate;
	}

	public function getStartTime(): DateTime {
		return $this->startTime;
	}

	public function setStartTime( DateTime $startTime ) {
		$this->startTime = $startTime;
	}

	public function getEndTime(): DateTime {
		return $this->endTime;
	}

	public function setEndTime( DateTime $endTime ): void {
		$this->endTime = $endTime;
	}

	public function getComment(): string {
		return $this->comment;
	}

	public function setComment( string $comment ): void {
		$this->comment = $comment;
	}
}
