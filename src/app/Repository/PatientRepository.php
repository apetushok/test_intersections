<?php

namespace App\Repository;

use App\Model\Patient;
use PDO;

class PatientRepository {
	public function __construct( private PDO $pdo )  {
	}

	public function findById( int $id ) {
		$stmt = $this->pdo->prepare("SELECT * FROM patient WHERE id = ?");
		$stmt->execute([$id]);
		$patientData = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$patientData) {
			return null; // Patient not found
		}

		return new Patient($patientData['id'], $patientData['name'], $patientData['mobile_phone']);
	}
}
