<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function home()
    {
        // レシピを取得しています
        $recipes =
            Recipe::select(
                'recipes.id',
                'recipes.title',
                'recipes.description',
                'recipes.created_at',
                'recipes.image',
                'users.name'
            )
            ->join('users', 'users.id', '=', 'recipes.user_id') // ユーザーテーブルとの結合
            ->orderBy('recipes.created_at', 'desc') // 作成日時で降順に並べ替え
            ->limit(3) // 3つに制限
            ->get(); // 取得
        // dd($recipes); // デバッグ用にレシピを表示

        $popular =
            Recipe::select(
                'recipes.id',
                'recipes.title',
                'recipes.description',
                'recipes.created_at',
                'recipes.image',
                'recipes.views',
                'users.name'
            )
            ->join('users', 'users.id', '=', 'recipes.user_id') // ユーザーテーブルとの結合
            ->orderBy('recipes.views', 'desc') // 作成日時で降順に並べ替え
            ->limit(2) // 2つに制限
            ->get(); // 取得
        // dd($popular); // デバッグ用にレシピを表示

        return view('home', compact('recipes', 'popular')); // ビューを返す
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // リソースの一覧を表示
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 新しいリソースの作成フォームを表示
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 新しいリソースを保存
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 指定されたリソースを表示
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 指定されたリソースの編集フォームを表示
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 指定されたリソースを更新
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 指定されたリソースを削除
    }
}
