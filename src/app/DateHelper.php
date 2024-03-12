<?php

namespace App;

use DateTime;
use InvalidArgumentException;

class DateHelper {
	public static function stringToDateTime( string $dateString, $format = 'Y-m-d'): DateTime {
		$dateTime = DateTime::createFromFormat($format, $dateString);

		$errors = DateTime::getLastErrors();
		if ( $errors !== false && ( $errors['error_count'] > 0 || $errors['warning_count'] > 0 ) ) {
			throw new InvalidArgumentException("Invalid date string: $dateString");
		}

		return $dateTime;
	}
}
