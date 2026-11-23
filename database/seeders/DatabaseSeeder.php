<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'anika.rashid@g.bracu.ac.bd']);
        $admin->name = 'Shop Admin';
        $admin->password = Hash::make('@Harun12');
        $admin->role = 'admin';
        $admin->save();
    }
}