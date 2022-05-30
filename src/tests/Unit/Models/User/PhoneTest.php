<?php

namespace Tests\Unit\Models\User;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_default()
    {
        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $this->assertFalse($user->isPhoneVerified());
    }

    /** @test */
    public function test_request_empty_phone()
    {

        $user = User::factory()->create([
            'phone' => null,
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $this->expectExceptionMessage('Phone number is empty.');
        $user->requestPhoneVerification();
    }

    /** @test */
    public function test_request(): void
    {
        $user = User::factory()->create([
            'phone' => '78000000000',
            'phone_verified' => false,
            'phone_verify_token' => null,
        ]);

        $token = $user->requestPhoneVerification();
        $this->assertFalse($user->isPhoneVerified());
        $this->assertNotEmpty($token);
    }
}
