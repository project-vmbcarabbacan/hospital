<?php

namespace App\Domain\Interfaces\Repositories;

use App\Domain\Entities\RatingEntity;
use App\Domain\ValueObjects\IdObj;

interface RatingRepositoryInterface
{
    public function addRating(RatingEntity $data);
    public function updateRating(IdObj $id, RatingEntity $data);
    public function getRatingById(IdObj $id);
    public function getAverageByDoctorId(IdObj $doctor_id);
}
