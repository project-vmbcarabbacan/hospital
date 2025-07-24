<?php

use App\Application\DTOs\LoginDto;
use App\Domain\ValueObjects\PasswordObj;
use App\Domain\ValueObjects\RoleIdObj;
use App\Models\User;
use App\Application\Services\AuthService;
use App\Domain\Interfaces\Repositories\AuthRepositoryInterface;
use App\Domain\Interfaces\Services\RoleServiceInterface;
use App\Domain\ValueObjects\EmailObj;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\instance;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@domain.com',
        'password' => Hash::make('Password123'),
        'role_id' => 1,
    ]);
});

it('returns user by email via service', function () {

        // Create a mock for the createToken return value
    $mockTokenObject = new class {
        public string $plainTextToken = 'mocked-token';
    };

    // Partial mock of the User model to override createToken
    $user = Mockery::mock($this->user)->makePartial();
    $user->shouldReceive('createToken')
        ->once()
        ->with('Super Admin', ['view_users', 'edit_users'])
        ->andReturn($mockTokenObject);

    // Mock the repository
    $mockAuthRepo = Mockery::mock(AuthRepositoryInterface::class);
    $mockAuthRepo->shouldReceive('login')
        ->once()
        ->with(Mockery::on(function ($email) {
            return $email instanceof EmailObj && $email->value() === 'test@domain.com';
        }), Mockery::on(function ($password) {
            return $password instanceof PasswordObj && $password->value() === 'Password123';
        }))
        ->andReturn($user);

    // Mock the role service
    $mockRoleService = Mockery::mock(RoleServiceInterface::class);
    $mockRoleService->shouldReceive('getRoleName')
        ->once()
        ->with(Mockery::on(function ($roleId) {
            return $roleId instanceof RoleIdObj && $roleId->value() === 1;
        }))
        ->andReturn('Super Admin');
    $mockRoleService->shouldReceive('getPermissionsByRoleId')
        ->once()
        ->with(Mockery::on(function ($roleId) {
            return $roleId instanceof RoleIdObj && $roleId->value() === 1;
        }))
        ->andReturn(['view_users', 'edit_users']);

    $loginDto = LoginDto::fromArray([
        'email' => 'test@domain.com',
        'password' => 'Password123',
    ]);
    // Call the service
    $service = new AuthService($mockAuthRepo, $mockRoleService);
    $result = $service->login($loginDto);

    // Assert the result
    expect($result)->toBeArray()
        ->and($result['user'])->toBeInstanceOf(User::class)
        ->and($result['token'])->toBe('mocked-token');
});
