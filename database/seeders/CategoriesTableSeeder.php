<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // カテゴリのデータを定義
        $categories = [
            ['name' => 'メイン'],    // メインカテゴリ
            ['name' => '副菜'],    // 副菜カテゴリ
            ['name' => 'デザート'], // デザートカテゴリ
        ];

        // カテゴリをデータベースに挿入
        foreach ($categories as $c) {
            DB::table('categories')->insert($c);
        }
    }
}
