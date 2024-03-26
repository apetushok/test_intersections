<?php

namespace App\Presentation;

class BookingView {
	public static function displayAllBookingsView( array $bookings, string $date ) {
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Conflicting Bookings</title>
            <style>
				table {
					border-collapse: collapse;
				}
				th, td {
					border: 1px solid #dcdcdc;
					padding: 8px;
					text-align: left;
				}
				th {
					background-color: #f2f2f2;
				}
            </style>
		</head>
		<body>
		<h3>
            <?php if( $bookings === [] ): ?>
                There is no conflicting bookings
            <?php else: ?>
                There are <?php echo count( $bookings ); ?> conflicting bookings on <?php self::print( $date ); ?>
			<?php endif; ?>
        </h3>
		<table>
			<thead>
			<tr>
				<th>Time</th>
				<th>Patient</th>
				<th>Mobile phone number</th>
				<th>Comment</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($bookings as $booking): ?>
				<tr>
                    <td><?php self::print( $booking->getStartTime()->format('H:i') ); ?> - <?php self::print( $booking->getEndTime()->format('H:i') ); ?></td>
                    <td><?php self::print( $booking->getPatient()->getName() ); ?></td>
					<td><?php self::print( $booking->getPatient()->getMobilePhone() ); ?></td>
					<td><?php self::print( $booking->getComment() ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</body>
		</html>
		<?php
	}

    private static function print( string $input ): void {
		echo self::escape($input);
    }

	private static function escape( string $input ): string {
		return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
	}

}
