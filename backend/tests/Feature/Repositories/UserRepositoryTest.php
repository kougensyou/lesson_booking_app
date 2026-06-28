<?php

namespace Tests\Feature\Repositories;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_user_returns_user_with_image_url(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Get User Test',
            'email' => 'get-user@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => '/images/user/test_user.png',
            'zip_code' => '123-4567',
            'tel_no' => '080-1234-5678',
            'address' => 'Tokyo Test 1-1-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = (new UserRepository())->getUser($userId);

        $this->assertSame('Get User Test', $result->name);
        $this->assertSame('get-user@example.com', $result->email);
        $this->assertSame('123-4567', $result->zip_code);
        $this->assertSame('080-1234-5678', $result->tel_no);
        $this->assertSame('1990-01-01', $result->birth_date);
        $this->assertSame('/storage/images/user/test_user.png', $result->image_url);
    }

    public function test_get_user_returns_null_image_url_when_no_image(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'No Image User',
            'email' => 'no-image@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1992-05-15',
            'image_path' => null,
            'zip_code' => null,
            'tel_no' => null,
            'address' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = (new UserRepository())->getUser($userId);

        $this->assertSame('No Image User', $result->name);
        $this->assertNull($result->image_url);
    }

    public function test_update_user_updates_data(): void
    {
        $userId = DB::table('user')->insertGetId([
            'name' => 'Before Update',
            'email' => 'before-update@example.com',
            'password' => bcrypt('password'),
            'birth_date' => '1990-01-01',
            'image_path' => null,
            'zip_code' => '000-0000',
            'tel_no' => null,
            'address' => 'Old Address',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        (new UserRepository())->updateUser($userId, [
            'name' => 'After Update',
            'zip_code' => '999-9999',
            'address' => 'New Address',
        ]);

        $user = DB::table('user')->where('id', $userId)->first();

        $this->assertSame('After Update', $user->name);
        $this->assertSame('999-9999', $user->zip_code);
        $this->assertSame('New Address', $user->address);
        // Verify unchanged fields
        $this->assertSame('before-update@example.com', $user->email);
        $this->assertSame('1990-01-01', $user->birth_date);
    }

    public function test_find_user_by_email_returns_user(): void
    {
        DB::table('user')->insert([
            [
                'name' => 'User One',
                'email' => 'user-one@example.com',
                'password' => bcrypt('password'),
                'birth_date' => '1990-01-01',
                'image_path' => null,
                'zip_code' => null,
                'tel_no' => null,
                'address' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Two',
                'email' => 'user-two@example.com',
                'password' => bcrypt('password'),
                'birth_date' => '1992-02-02',
                'image_path' => null,
                'zip_code' => null,
                'tel_no' => null,
                'address' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $result = (new UserRepository())->findUserByEmail('user-two@example.com');

        $this->assertSame('User Two', $result->name);
        $this->assertSame('user-two@example.com', $result->email);
    }
}
