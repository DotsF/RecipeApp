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
                <img id="preview" class="object-cover aspect-video w-full mrounded-none" src="/images/recipe-dummy.png"
                    alt="recipe-image">
                <input type="file" id="image" name="image"
                    class="border border-gray-300 p-2 mb-4 w-full rounded">
            </div>
            <div class="col-span-1 p-4">
                <!-- レシピ名の入力 -->
                <input type="text" name="title" value="{{ old('title') }}" placeholder="レシピ名"
                    class="border border-gray-300 p-2 mb-4 w-full rounded">
                <!-- レシピの説明の入力 -->
                <textarea name="description" placeholder="レシピの説明" class="border border-gray-300 p-2 mb-4 w-full rounded">{{ old('description') }}</textarea>
                <!-- カテゴリーの選択 -->
                <select name="category" class="border border-gray-300 p-2 mb-4 w-full rounded">
                    <option value="">カテゴリー</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c['id'] }}" {{ old('category') ?? null == $c['id'] ? 'selected' : '' }}>
                            {{ $c['name'] }}
                        </option>
                    @endforeach
                </select>
                <!-- 材料の入力 -->
                <h4 class="text-bold text-xl mb-4">材料を入力</h4>
                <div id="ingredients">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="ingredient flex items-center mb-4">
                            @include('components.icon.bars-3')
                            <input type="text" name="ingredients[{{ $i }}][name]"
                                value="{{ old('title') }}" placeholder="材料名"
                                class="ingredient-name border border-gray-300 p-2 w-full rounded ml-4">
                            <p class="mx-2">:</p>
                            <input type="text" name="ingredients[{{ $i }}][quantity]" placeholder="分量"
                                class="ingredient-quantity border border-gray-300 p-2 w-full rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="ingredient-delete w-10 h-10 ml-4 cursor-pointer text-gray-600">
                                <path fill-rule="evenodd"
                                    d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endfor
                </div>
                {{-- add button --}}
                <div class="flex justify-end">
                    <button type="button" id="ingredient-add"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded mb-4">
                        材料を追加する
                    </button>
                </div>
            </div>
        </div>
        <!-- 投稿ボタン -->
        <div class="flex justify-center mt-4">
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded">
                レシピを投稿する
            </button>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="step-delete w-10 h-10 ml-4 cursor-pointer text-gray-600">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @endfor
        </div>
        {{-- add button --}}
        <div class="flex justify-end">
            <button type="button" id="step-add"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                手順を追加する
            </button>
        </div>
    </form>
</x-app-layout>
