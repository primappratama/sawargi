<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder {
    public function run(): void {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Admin SAWARGI',
                'username' => 'admin',
                'password' => Hash::make('sawargi2025'),
            ]
        );
        $this->command->info('✅ Admin user created: admin / sawargi2025');
    }
}