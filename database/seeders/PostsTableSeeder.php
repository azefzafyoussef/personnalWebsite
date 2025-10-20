<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;


class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('email', 'admin@noteshub.com')->first();
        $categories = Category::all();

        $posts = [
            [
                'title' => 'Introduction to Calculus',
                'slug' => Str::slug('History'),
                'content' => '<h2>What is Calculus?</h2><p>Calculus is the mathematical study of continuous change...</p><h3>Key Concepts:</h3><ul><li>Derivatives</li><li>Integrals</li><li>Limits</li></ul>',
                'excerpt' => 'A comprehensive introduction to calculus concepts including derivatives and integrals.',
                'category_id' => $categories->where('name', 'Mathematics')->first()->id,
                'views' => 150,
                'downloads' => 45
            ],
            [
                'title' => 'Python Programming Basics',
                'slug' => Str::slug('Literature'),
                'content' => '<h2>Getting Started with Python</h2><p>Python is a high-level programming language known for its simplicity...</p><h3>Basic Syntax:</h3><pre><code>print("Hello, World!")</code></pre>',
                'excerpt' => 'Learn the fundamentals of Python programming language with practical examples.',
                'category_id' => $categories->where('name', 'Computer Science')->first()->id,
                'views' => 200,
                'downloads' => 78
            ],
            [
                'title' => 'Newton\'s Laws of Motion',
                'slug' => Str::slug('Business'),
                'content' => '<h2>Newton\'s Three Laws</h2><p>Sir Isaac Newton formulated three fundamental laws of motion...</p><ol><li>First Law: Inertia</li><li>Second Law: F=ma</li><li>Third Law: Action-Reaction</li></ol>',
                'excerpt' => 'Detailed explanation of Newton\'s three laws of motion with real-world examples.',
                'category_id' => $categories->where('name', 'Physics')->first()->id,
                'views' => 120,
                'downloads' => 32
            ],
            [
                'title' => 'Cell Biology Fundamentals',
                'slug' => Str::slug('Computer Science'),
                'content' => '<h2>Understanding Cells</h2><p>Cells are the basic building blocks of all living organisms...</p><h3>Cell Types:</h3><ul><li>Prokaryotic Cells</li><li>Eukaryotic Cells</li></ul>',
                'excerpt' => 'Comprehensive guide to cell structure, function, and types of cells.',
                'category_id' => $categories->where('name', 'Biology')->first()->id,
                'views' => 95,
                'downloads' => 28
            ],
            [
                'title' => 'Chemical Reactions Overview',
                'slug' => Str::slug('Physics'),
                'content' => '<h2>Types of Chemical Reactions</h2><p>Chemical reactions involve the transformation of substances...</p><h3>Common Reaction Types:</h3><ul><li>Synthesis</li><li>Decomposition</li><li>Combustion</li></ul>',
                'excerpt' => 'Learn about different types of chemical reactions and their characteristics.',
                'category_id' => $categories->where('name', 'Chemistry')->first()->id,
                'views' => 110,
                'downloads' => 41
            ]
        ];

        foreach ($posts as $post) {
            Post::create(array_merge($post, [
                'user_id' => $adminUser->id,
                'is_published' => true
            ]));
        }

        $this->command->info('Sample posts created successfully!');
    }
}