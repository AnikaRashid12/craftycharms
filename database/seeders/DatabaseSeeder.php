<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@craftycharms.test']);
        $admin->name = 'Shop Admin';
        $admin->password = Hash::make('ChangeMe123!');
        $admin->role = 'admin';
        $admin->save();
    }
}