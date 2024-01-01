<x-app-layout>
    <x-slot name="script">
        <script src="/js/recipe/create.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    </x-slot>
    <!-- recipe.store ルートへのフォームのアクション -->
    <form action="{{ route('recipe.store') }}" method="POST" class="p-4 mx-auto bg-white rounded"
        enctype="multipart/form-data">
        @csrf <!-- CSRF（クロスサイトリクエストフォージェリ） トークン -->
        {{ Breadcrumbs::render('create') }} <!-- パンくずリストの表示 -->
        <div class="grid grid-cols-2 rounded border border-gray-400 mt-4">
            <div class="col-span-1">
                <!-- レシピ画像 -->
                <img class="object-cover aspect-video w-full mrounded-none" src="/images/recipe-dummy.png"
                    alt="recipe-image">
                <input type="file" name="image" class="border border-gray-300 p-2 mb-4 w-full rounded">
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
        {{-- underline --}}
        <hr class="my-4">
        <h4 class="text-bold text-xl mb-4">手順を入力</h4>
        <div id="steps">
            @for ($i = 1; $i < 4; $i++)
                <div class="step flex justify-between items-center mb-2">
                    @include('components.icon.bars-3')
                    <p class="text-center step-number w-16">手順{{ $i }}</p>
                    <input type="text" name="steps[]" placeholder="手順を入力"
                        class="border border-gray-300 p-2 w-full rounded">
                    @include('components.icon.trash')
                </div>
            @endfor
        </div>
        {{-- add button --}}
        <button type="button" id="step-add"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            手順を追加する
        </button>
    </form>
</x-app-layout>
