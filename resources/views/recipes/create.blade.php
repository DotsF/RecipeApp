<x-app-layout>
    <!-- recipe.store ルートへのフォームのアクション -->
    <form action="{{ route('recipe.store') }}" method="POST" class="p-4 mx-auto bg-white rounded">
        @csrf <!-- CSRF（クロスサイトリクエストフォージェリ） トークン -->
        {{ Breadcrumbs::render('create') }} <!-- パンくずリストの表示 -->
        <div class="grid grid-cols-2 rounded border border-gray-400 mt-4">
            <div class="col-span-1">
                <img class="object-cover aspect-video w-full mrounded-none" src="/images/recipe-dummy.png"
                    alt="recipe-image"> <!-- レシピ画像 -->
            </div>
            <div class="col-span-1 p-4">
                <!-- レシピ名の入力 -->
                <input type="text" name="title" placeholder="レシピ名"
                    class="border border-gray-300 p-2 mb-4 w-full rounded">
                <!-- レシピの説明の入力 -->
                <textarea name="description" placeholder="レシピの説明" class="border border-gray-300 p-2 mb-4 w-full rounded"></textarea>
                <!-- カテゴリーの選択 -->
                <select name="category" class="border border-gray-300 p-2 mb-4 w-full rounded">
                    <option value="">カテゴリー</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                    @endforeach
                </select>
                <!-- 投稿ボタン -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded">
                        レシピを投稿する
                    </button>
                </div>
            </div>

        </div>
    </form>
</x-app-layout>
