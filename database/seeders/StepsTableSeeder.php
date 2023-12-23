<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピIDを取得
        $recipes = DB::table('recipes')->pluck('id')->toArray();

        // 各レシピに対してステップを3から6個ランダムに生成
        foreach ($recipes as $recipeId) {
            $numberOfSteps = rand(3, 6); // 各レシピに対して3から6個のステップをランダムに生成

            // 生成したステップをデータベースに挿入
            for ($i = 1; $i <= $numberOfSteps; $i++) {
                DB::table('steps')->insert([
                    'recipe_id' => $recipeId, // レシピIDを設定
                    'step_number' => $i, // ステップ番号を設定
                    'description' => 'Step ' . $i . ' description for recipe ' . $recipeId, // ステップの説明を生成
                    'created_at' => now(), // 現在の日時を設定
                    'updated_at' => now(), // 現在の日時を設定
                ]);
            }
        }
    }
}
