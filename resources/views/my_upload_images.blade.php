<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My画像一覧</title>

    {{-- Javascript のビルドツール vite を使って生成されるコードを読み込みする --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1 class ="mb-4 text-3xl font-extrabold">My画像一覧</h1>


    <div>
        <form action="/upload_images" method="GET">
            <input  class="group rounded-2xl h-12 w-48 bg-green-500 font-bold text-lg text-white relative overflow-hidden" type="submit"  value="一覧表示へ戻る">
            <div class="absolute duration-300 inset-0 w-full h-full transition-all scale-0 group-hover:scale-100 group-hover:bg-white/30 rounded-2xl">
            </div>
        </form>
    </div>

    <form action="" method="GET">
        <div class="flex items-center max-w-md mx-auto bg-white rounded-lg " x-data="{ search: '' }">
            <div class="w-full">
                <input type="text" class="w-full px-4 py-1 text-gray-800 rounded-full focus:outline-none"
                placeholder="search" x-model="search" name="keyword" value="{{ $keyword }}">
            </div>
            <div>
                <button type="submit" class="flex items-center bg-blue-500 justify-center w-12 h-12 text-white rounded-r-lg"
                :class="(search.length > 0) ? 'bg-purple-500' : 'bg-gray-500 cursor-not-allowed'"
                :disabled="search.length == 0" value="検索">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>


    <table border='1'>
        <tr>
            <th>ファイル名</th>
            <th>画像</th>
            <th>URL</th>
            <th>備考</th>
            <th>ユーザー</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        @foreach ($upload_images as $upload_image)
            <tr>
                <td>{{$upload_image->filename}}</td>
                <td><img src='{{$upload_image->filepath}}' width='200'></td>
                <td>http://localhost/{{$upload_image->filepath}}</td>
                <td>{{$upload_image->memo}}</td>
                <td>{{$upload_image->user_id}}</td>
                <td><a href="/edit/{{$upload_image->id}}" class="p-3 bg-white border rounded-full w-full font-semibold">編集</a></td>
                <td>
                    <form action="delete/{{$upload_image->id}}" method="post">
                        <input class="p-3 bg-black rounded-full text-white w-full font-semibold" type="submit"  name="delete" value="削除">
                        @csrf
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
