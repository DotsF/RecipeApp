<?php

namespace Database\Seeders;

// Illuminate\Database\Console\Seeds\WithoutModelEvents は使用されていません
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seederクラスを呼び出し、データベースに初期データを挿入（外部キー制約を考慮する）
        $this->call([
            UsersTableSeeder::class, // Usersテーブルの初期データを挿入
            CategoriesTableSeeder::class, // Categoriesテーブルの初期データを挿入
            RecipesTableSeeder::class, // Recipesテーブルの初期データを挿入
            StepsTableSeeder::class, // Stepsテーブルの初期データを挿入
            IngredientsTableSeeder::class, // Ingredientsテーブルの初期データを挿入
            ReviewsTableSeeder::class // Reviewsテーブルの初期データを挿入
        ]);
    }
}
