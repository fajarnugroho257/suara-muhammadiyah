<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'role_id' => 'R0001',
            'role_name' => 'developer',
        ]);
        Role::create([
            'role_id' => 'R0002',
            'role_name' => 'admin',
        ]);
        Role::create([
            'role_id' => 'R0003',
            'role_name' => 'pengguna',
        ]);
    }
}
