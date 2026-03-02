<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'icon' => '📚',
                'color' => '#3b82f6',
                'description' => 'Fictional stories and novels',
            ],
            [
                'name' => 'Science Fiction',
                'icon' => '🚀',
                'color' => '#8b5cf6',
                'description' => 'Science fiction and futuristic stories',
            ],
            [
                'name' => 'Romance',
                'icon' => '💕',
                'color' => '#ec4899',
                'description' => 'Romance novels and love stories',
            ],
            [
                'name' => 'Fantasy',
                'icon' => '🐉',
                'color' => '#6366f1',
                'description' => 'Fantasy novels with magical elements',
            ],
            [
                'name' => 'Mystery',
                'icon' => '🔍',
                'color' => '#4b5563',
                'description' => 'Mystery and detective stories',
            ],
            [
                'name' => 'Non-Fiction',
                'icon' => '📖',
                'color' => '#10b981',
                'description' => 'Non-fiction books and factual content',
            ],
            [
                'name' => 'Self-Help',
                'icon' => '💡',
                'color' => '#eab308',
                'description' => 'Self-improvement and personal development',
            ],
            [
                'name' => 'Biography',
                'icon' => '👤',
                'color' => '#ef4444',
                'description' => 'Biographies and memoirs',
            ],
            [
                'name' => 'History',
                'icon' => '📜',
                'color' => '#92400e',
                'description' => 'Historical books and accounts',
            ],
            [
                'name' => 'Science',
                'icon' => '🔬',
                'color' => '#06b6d4',
                'description' => 'Scientific books and research',
            ],
            [
                'name' => 'Technology',
                'icon' => '💻',
                'color' => '#6366f1',
                'description' => 'Technology and programming books',
            ],
            [
                'name' => 'Business',
                'icon' => '💼',
                'color' => '#1e40af',
                'description' => 'Business and entrepreneurship',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'color' => $category['color'],
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}
