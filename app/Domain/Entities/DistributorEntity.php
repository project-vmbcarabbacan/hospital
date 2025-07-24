<?php

namespace App\Domain\Entities;

class DistributorEntity {

    public function __construct(
        public readonly string $name,
        public readonly string $contact,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?string $photo = null,
    ){}
}
