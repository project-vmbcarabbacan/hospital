<?php

namespace App\Http\Resources;

use App\Domain\ValueObjects\DateObj;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{

    protected string $roleName, $rating;

    public function __construct($resource, string $roleName, float $rating)
    {
        parent::__construct($resource);
        $this->roleName = $roleName;
        $this->rating = $rating;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        return [
            'profile_information' => $this->setProfile($this),
            'basic_information' => $this->setBasic($this),
            'bio' => $this->information->bio
        ];
    }

    private function setProfile($user)
    {
        $baseUrl = config('app.url');

        $avatarUrl = $user->information->profile_photo;

        if (empty($baseUrl) || !filter_var($avatarUrl, FILTER_VALIDATE_URL)) {
            $avatarUrl = Storage::disk('public')->url($avatarUrl);
        }


        return [
            'user_id' => $user->id,
            'name' => $user->information->first_name . ' ' . $user->information->last_name,
            'email' => $user->email,
            'contact' => $user->information->phone,
            'avatar_url' => $avatarUrl,
            'status' => ucwords($user->status),
            'role' => $this->roleName,
            'department' => $user->headDepartment ? $user->headDepartment->name : '-',
            'rating' => (float) $this->rating
        ];
    }

    private function setBasic($user)
    {
        $hired_date = new DateObj($user->information->hired_date);
        return [
            'employee_id' => $user->id,
            'hired_date' => $hired_date->value(),
            'work_for' => $hired_date->getDays(),
            'license_number' => $user->information->license_number,
            'license_expiry' => $user->information->license_expiry,
            'birth_date' => $user->information->birthdate,
            'address' => $user->information->address,
            'days_of_working' => $user->information->days_of_working,
            'work_timing' => $user->information->work_timing,
            'occupation_type' => $user->information->occupation_type

        ];
    }
}
