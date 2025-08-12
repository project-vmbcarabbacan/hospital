<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            'basic_information' => $this->setBasic($this)
        ];
    }

    private function setProfile($user)
    {
        return [
            'user_id' => $user->id,
            'name' => $user->information->first_name . ' ' . $user->information->last_name,
            'email' => $user->email,
            'contact' => $user->information->phone,
            'avatar_url' => $user->information->profile_photo,
            'status' => $user->status,
            'role' => $this->roleName,
            'department' => $user->headDepartment ? $user->headDepartment->name : '-',
            'rating' => (float) $this->rating
        ];
    }

    private function setBasic($request)
    {
        return [
            'last' => 'carabbacan'
        ];
    }
}
