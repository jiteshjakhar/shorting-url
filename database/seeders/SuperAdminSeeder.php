<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
            INSERT INTO users (name, email, email_verified_at, password, role, company_id, created_at, updated_at)
            VALUES (
                'Super Admin',
                'superadmin@sembark.com',
                NOW(),
                '".Hash::make('12345678')."',
                'SuperAdmin',
                NULL,
                NOW(),
                NOW()
            )
        ");
    }
}
