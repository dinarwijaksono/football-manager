<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'test' . random_int(1, 9999);

        Profile::insert([
            'name' => $name,
            'managed_club' => null,
            'created_at' => round(microtime(true) * 100),
            'updated_at' => round(microtime(true) * 100),
        ]);
    }
}
