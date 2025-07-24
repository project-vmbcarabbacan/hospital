<?php

namespace App\Http\Requests\Auth;

use App\Domain\Enums\RoleEnum;
use App\Domain\Interfaces\Services\RoleServiceInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow if user is not logged in (e.g., customer self-registering)
        if (!auth()->check()) {
            return true;
        }

        $user = auth()->user();

        $requiredPermissions = [
            'full_system_control',
            'manage_staff_access',
            'manage_recruitment',
            'manage_hr',
            'manage_doctors',
        ];

        return $user->hasAnyPermission($requiredPermissions, app(RoleServiceInterface::class));
    }

    public function prepareForValidation(): void
    {
        $role_id = RoleEnum::PATIENT;
        if (!auth()->check()) {
            $this->merge([
                'role_id' => $role_id->value,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'role_id'       => 'required|integer',
            'status'        => 'required|in:active,inactive',

            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
            'birthdate'     => 'nullable|date',
            'gender'        => 'nullable|in:male,female,other',

            // Accept only png, jpg, jpeg images, max 2MB (optional)
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
