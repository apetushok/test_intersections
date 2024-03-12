<?php

namespace App\Model;

class Patient {
	public function __construct(
		private int $id,
		private string $name,
		private string $mobilePhone
	) {
	}

	public function getId(): int {
		return $this->id;
	}

	public function setId( int $id ):void {
		$this->id = $id;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName( string $name ): void {
		$this->name = $name;
	}

	public function getMobilePhone(): string {
		return $this->mobilePhone;
	}

	public function setMobilePhone( string $mobilePhone ): void {
		$this->mobilePhone = $mobilePhone;
	}
}
