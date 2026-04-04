<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientStaff;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now  = now();
        $role = Role::query()
            ->where('slug', 'Client-staff')
            ->orWhere('name', 'Client-staff')
            ->first();

        $permissions = is_array($role?->permissions) ? $role->permissions : [
            'manage_post',
            'manage_social_profile',
            'manage_subscription',
            'manage_team',
            'manage_campaigns',
            'manage_ticket',
            'manage_setting',
            'manage_api',
        ];

        $clientData = [
            'company_name'          => 'SpaGreen Client',
            'slug'                  => 'spagreen-client',
            'country_id'            => 19,
            'timezone'              => 'Asia/Dhaka',
            'status'                => 1,
            'webhook_verify_token'  => Str::random(30),
            'api_key'               => Str::random(30),
            'default_language'      => 'en',
            'updated_at'            => $now,
        ];

        if (Schema::hasColumn('clients', 'first_name')) {
            $clientData['first_name'] = 'SpaGreen';
        }
        if (Schema::hasColumn('clients', 'last_name')) {
            $clientData['last_name'] = 'Client';
        }

        $client = Client::query()->updateOrCreate(
            ['slug' => 'spagreen-client'],
            $clientData
        );

        $userData = [
            'first_name'        => 'Demo',
            'last_name'         => 'Client',
            'email'             => 'client@spagreen.net',
            'password'          => Hash::make('123456'),
            'phone'             => '01700000000',
            'client_id'         => $client->id,
            'user_type'         => 'client-staff',
            'role_id'           => $role?->id ?? 3,
            'permissions'       => $permissions,
            'status'            => 1,
            'country_id'        => 19,
            'email_verified_at' => $now,
            'updated_at'        => $now,
        ];

        if (Schema::hasColumn('users', 'is_primary')) {
            $userData['is_primary'] = 1;
        }
        if (Schema::hasColumn('users', 'token')) {
            $userData['token'] = Str::random(60);
        }
        if (Schema::hasColumn('users', 'token_valid_until')) {
            $userData['token_valid_until'] = $now->copy()->addDays(30);
        }

        $user = User::query()->updateOrCreate(
            ['email' => 'client@spagreen.net'],
            $userData
        );

        ClientStaff::query()->updateOrCreate(
            [
                'user_id'   => $user->id,
                'client_id' => $client->id,
            ],
            [
                'slug' => 'spagreen-client',
            ]
        );
    }
}
