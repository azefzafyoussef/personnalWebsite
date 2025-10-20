<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Mathematics',
                'slug' => Str::slug('Mathematics'),
                'description' => 'Notes related to mathematics, algebra, calculus, and statistics',
                'color' => '#4361ee',
                'icon' => 'fas fa-calculator'
            ],
            [
                'name' => 'Physics',
                'slug' => Str::slug('Physics'),
                'description' => 'Physics concepts, formulas, and theories',
                'color' => '#f72585',
                'icon' => 'fas fa-atom'
            ],
            [
                'name' => 'Computer Science',
                'slug' => Str::slug('Computer Science'),
                'description' => 'Programming, algorithms, and computer science topics',
                'color' => '#4cc9f0',
                'icon' => 'fas fa-laptop-code'
            ],
            [
                'name' => 'Biology',
                'slug' => Str::slug('Biology'),
                'description' => 'Biological sciences, anatomy, and life sciences',
                'color' => '#38b000',
                'icon' => 'fas fa-dna'
            ],
            [
                'name' => 'Chemistry',
                'slug' => Str::slug('Chemistry'),
                'description' => 'Chemical reactions, periodic table, and laboratory notes',
                'color' => '#ff9e00',
                'icon' => 'fas fa-flask'
            ],
            [
                'name' => 'History',
                'slug' => Str::slug('History'),
                'description' => 'Historical events, timelines, and cultural studies',
                'color' => '#9d4edd',
                'icon' => 'fas fa-monument'
            ],
            [
                'name' => 'Literature',
                'slug' => Str::slug('Literature'),
                'description' => 'Books, poems, and literary analysis',
                'color' => '#e63946',
                'icon' => 'fas fa-book-open'
            ],
            [
                'name' => 'Business',
                'slug' => Str::slug('Business'),
                'description' => 'Business studies, economics, and management',
                'color' => '#2a9d8f',
                'icon' => 'fas fa-chart-line'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories created successfully!');
    }
}