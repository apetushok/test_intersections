<?php

namespace App\Presentation;

class BookingView {
	public static function displayAllBookingsView( $bookings ) {
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>All Bookings</title>
		</head>
		<body>
		<h1>All Bookings</h1>
		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Patient ID</th>
				<th>Booking Date</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Comment</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($bookings as $booking): ?>
				<tr>
					<td><?php echo $booking->getId(); ?></td>
					<td><?php echo $booking->getPatientId(); ?></td>
					<td><?php echo $booking->getBookingDate()->format('Y-m-d'); ?></td>
					<td><?php echo $booking->getStartTime()->format('H:i'); ?></td>
					<td><?php echo $booking->getEndTime()->format('H:i'); ?></td>
					<td><?php echo $booking->getComment(); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</body>
		</html>
		<?php
	}
}
