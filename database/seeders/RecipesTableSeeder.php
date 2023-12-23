<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // カテゴリのIDを取得
        $categories = DB::table('categories')->pluck('id')->toArray();

        // ユーザーのIDを取得
        $users = DB::table('users')->pluck('id')->toArray();

        // 画像タイプのリスト
        $image_types = ['food', 'recipe', 'cooking', 'dinner', 'lunch', 'breakfast', 'healthy', 'delicious', 'tasty', 'cake', 'coffee'];

        // 20回レシピを生成
        for ($i = 0; $i < 20; $i++) {
            // レシピ情報をデータベースに挿入
            DB::table('recipes')->insert([
                'id' => Str::uuid(), // UUIDを使用した新しいIDを生成
                'user_id' => $users[array_rand($users)], // ランダムなユーザーIDを選択
                'category_id' => $categories[array_rand($categories)], // ランダムなカテゴリーIDを選択
                'title' => 'Recipe of ' . Str::random(10), // ランダムなタイトルを生成
                'description' => 'This is a sample recipe description for ' . Str::random(10), // ランダムな説明を生成
                'image' => 'https://source.unsplash.com/random/?' . $image_types[rand(0, 10)], // ランダムな画像を選択
                'views' => rand(0, 500), // 0から500のランダムな閲覧数
                'created_at' => now(), // 現在の日時を設定
                'updated_at' => now(), // 現在の日時を設定
            ]);
        }
    }
}
