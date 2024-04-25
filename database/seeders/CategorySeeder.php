<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; /** represents categories table */

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function run(): void
    {
        /**
         * Games, Books, Programming, Mysql
         * 
         * */ 

         $categories = [
            [
                'name' => 'Travel',
                'created_at' => now(), //date & time
                'updated_at' => now()
            ],
            [
                'name' => 'Food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Programming',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'MySql',
                'created_at' => now(),
                'updated_at' => now()
            ]
            
         ];

         $this->category->insert($categories);
    }
}

/** php artisan migrate and php artisan db:seed */