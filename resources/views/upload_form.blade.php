<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>画像アップロードフォーム</title>

    {{-- Javascript のビルドツール vite を使って生成されるコードを読み込みする --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bodytext">
    <h1>画像アップロードフォーム</h1>
    <p>ログイン中のユーザーのみ表示されるページです</p>
    <p>こんにちは！{{ Auth::user()->name }}さん！</p>

    <form action="" method="POST" enctype="multipart/form-data">

        <div>
            <label for="image">
                <p>アップロード画像</p>
                <input id="image" type="file" name="image">
            </label>
        </div>

        <div>
            <label for="memo">
                <p>備考</p>
                <textarea name="memo" id="memo" cols="50" rows="10"></textarea>
            </label>
        </div>

        <div>
            <p>
                <input type="submit" value="アップロードする">
            </p>
        </div>

        @csrf
    </form>

    <form action="{{route('logout')}}" method="post">
        <button type="submit">ログアウト</button>
        @csrf
    </form>
</body>
</html>
