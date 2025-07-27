<?php

namespace App\Infrastructure\Repositories;

use App\Application\Utils\ExceptionConstants;
use App\Domain\Entities\RatingEntity;
use App\Domain\Interfaces\Repositories\RatingRepositoryInterface;
use App\Domain\ValueObjects\IdObj;
use App\Models\Doctor\Rating;
use Exception;

class RatingRepository implements RatingRepositoryInterface
{

    public function addRating(RatingEntity $data)
    {
        try {
            return Rating::create([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'rating' => $data->rating,
                'comment' => $data->comment,
                'is_approved' => $data->is_approved,
            ])->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateRating(IdObj $id, RatingEntity $data)
    {
        try {
            $rating = $this->getRatingById($id);

            if (!$rating)
                throw new Exception(ExceptionConstants::RATING_NOT_FOUND);

            $rating->update([
                'doctor_id' => $data->doctor_id->value(),
                'patient_id' => $data->patient_id->value(),
                'rating' => $data->rating,
                'comment' => $data->comment,
                'is_approved' => $data->is_approved,
            ]);

            return $rating->refresh();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getRatingById(IdObj $id)
    {
        return Rating::find($id->value());
    }

    public function getAverageByDoctorId(IdObj $doctor_id)
    {
        return round(Rating::where('doctor_id', $doctor_id->value())->where('is_approved', 1)->avg('rating'), 1);
    }
}
