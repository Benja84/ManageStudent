<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
                [
                    'firstname' => "Admin",
                    'lastname' => "Management",
                    'email' => "admin@admin.com",
                    'phone' => "0345811858",
                    'dateofbirth' => date('Y-m-d',strtotime('12-02-1991')),
                    'birthplace_postcode' => "111",
                    'birthplace_city' => "Antsirabe II",
                    'address_street' => "rue Jean Ralaimongo",
                    'address_postcode' => "110",
                    'address_city' => "Antsirabe",
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                
                ]
            );
        $user->assignRole('admin');
    }
}
