<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピのIDを取得
        $recipes = DB::table('recipes')->pluck('id')->toArray();

        // 材料の名前のリスト
        $ingredient_names = ['Salt', 'Sugar', 'Flour', 'Eggs', 'Milk', 'Butter', 'Oil', 'Vanilla extract', 'Baking powder', 'Cocoa powder'];

        // レシピごとに材料を生成
        foreach ($recipes as $recipe) {
            // 各レシピには2から5個の材料がある
            for ($i = 0; $i < rand(2, 5); $i++) {
                // 材料をデータベースに挿入
                DB::table('ingredients')->insert([
                    'recipe_id' => $recipe,
                    'name' => $ingredient_names[array_rand($ingredient_names)], // ランダムな材料名を選択
                    'quantity' => rand(1, 500) . 'g', // 1から500グラムのランダムな数量
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
