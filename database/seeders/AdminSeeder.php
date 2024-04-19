<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; //Use for hashing the password

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function run(): void
    {
        $this->user->name = "Administrator";
        $this->user->email = 'admin11@gmail.com';
        $this->user->password = Hash::make('admin12345');
        $this->user->role_id = User::ADMIN_ROLE_ID; //ADMIN_ROLE_ID = 1, USER_ROLE_ID = 2
        $this->user->save();
    }
}
