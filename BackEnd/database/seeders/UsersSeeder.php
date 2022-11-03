<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users;
use DateTime;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::create([
            'user_name' => 'admin_floyd',
            'name' => 'Floyd',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'email' => 'a@a',
            'image_pass' => '1/profile.png',
            'age' => 0,
            'gender' => 'male',
            'admin_flag' => 1,
            'delete_flag' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'deleted_at' => null,
        ]);

        Users::create([
            'user_name' => 'b',
            'name' => 'b',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'email' => 'b@b',
            'image_pass' => '2/profile.png',
            'age' => 19,
            'gender' => 'male',
            'admin_flag' => 0,
            'delete_flag' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            'deleted_at' => null,
        ]);
    }
}
