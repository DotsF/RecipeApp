<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピIDを取得
        $recipes = DB::table('recipes')->pluck('id')->toArray();

        // ユーザーIDを取得
        $users = DB::table('users')->pluck('id')->toArray();

        // コメントリスト
        $comments = ['Great recipe!', 'I loved it!', 'Will try again.', 'Not my favorite.', 'Easy to make and delicious!'];

        // 各レシピに対してランダムな1から3個のレビューを生成
        foreach ($recipes as $recipe) {
            for ($i = 0; $i < rand(1, 3); $i++) { // 各レシピに1から3のランダムなレビューを追加
                // レビュー情報をデータベースに挿入
                DB::table('reviews')->insert([
                    'user_id' => $users[array_rand($users)], // ランダムなユーザーIDを選択
                    'recipe_id' => $recipe, // 現在のレシピIDを設定
                    'rating' => rand(1, 5), // 1から5のランダムな評価
                    'comment' => $comments[array_rand($comments)], // ランダムなコメントを選択
                    'created_at' => now(), // 現在の日時を設定
                    'updated_at' => now(), // 現在の日時を設定
                ]);
            }
        }
    }
}
