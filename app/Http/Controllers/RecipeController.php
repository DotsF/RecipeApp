<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
    public function index(Request $request)
    {
        $filters = $request->all();
        // dd($filters);

        // レシピを取得しています
        $query =
            Recipe::query()->select(
                'recipes.id',
                'recipes.title',
                'recipes.description',
                'recipes.created_at',
                'recipes.image',
                'users.name',
                DB::raw('AVG(reviews.rating) as rating')
            )
            ->join('users', 'users.id', '=', 'recipes.user_id') // ユーザーテーブルとの結合
            ->leftJoin('reviews', 'reviews.recipe_id', '=', 'recipes.id')
            ->groupBy('recipes.id')
            ->orderBy('recipes.created_at', 'desc'); // 作成日時で降順に並べ替え

        if (!empty($filters)) {
            //もしカテゴリーが選択されていたら
            if (!empty($filters['categories'])) {
                //カテゴリーで絞り込み選択したカテゴリーIDが含まれている
                $query->whereIn('recipes.category_id', $filters['categories']);
            }

            // もし評価が入力されていたら
            if (!empty($filters['rating'])) {
                // 評価で絞り込み
                $query->havingRaw('AVG(reviews.rating) >= ?', [$filters['rating']])
                    ->orderBy('rating', 'desc'); // 作成日時で降順に並べ替え
            }

            //もしキーワードが入力されていたら
            if (!empty($filters['title'])) {
                //タイトルをあいまい一致絞り込み
                $query->where('recipes.title', 'like', '%' . $filters['title'] . '%');
            }
        }

        $recipes = $query->paginate(5); // 取得
        //dd($recipes);

        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories', 'filters')); // ビューを返す
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 新しいリソースの作成フォームを表示

        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // 新しいリソースを保存
        $posts = $request->all();
        $uuid = Str::uuid()->toString();
        // dd($posts);
        // リクエストから直接ファイルを指定して取得。
        $image = $request->file('image');
        // S3に画像をアップロード
        // Storageファサードを使用して、s3に対してプットファイルする。
        // putFileには引数が3つあり、recipeというファイルへ画像をアップロードした時点で、Webに公開される。
        $path = Storage::disk('s3')->putFile('recipe', $image, 'public');
        // dd($path);
        // S3のURLを取得
        $url = Storage::disk('s3')->url($path);
        // dd($url);
        // DBにはURLを保存
        Recipe::insert([
            'id' => $uuid,
            'title' => $posts['title'],
            'description' => $posts['description'],
            'category_id' => $posts['category'],
            'image' => $url,
            'user_id' => Auth::id()
        ]);

        $steps = [];
        foreach ($posts['steps'] as $key => $step) {
            $steps[$key] = [
                'recipe_id' => $uuid,
                'step_number' => $key + 1,
                'description' => $step
            ];
        }
        STEP::insert($steps);
        dd($steps);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'reviews.user', 'user'])
            ->where('recipes.id', $id)
            ->first();
        $recipe_record = Recipe::find($id);
        $recipe_record = $recipe->increment('views'); //PV数を増やす
        //リレーションで材料とステップを取得
        //dd($recipe);
        return view('recipes.show', compact('recipe'));
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
