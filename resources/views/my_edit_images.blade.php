<h2>編集</h2>

<form action="" method="POST">
    <div>
        <label>ファイル名</label>
        <textarea name="filename" id="filename">{{old('filename', $upload_images_edit->filename)}}</textarea>
    </div>

    <div>
        <label>備考</label>
        <textarea name="memo" id="memo">{{old('memo', $upload_images_edit->memo)}}</textarea>
    </div>
    <div>
        <input type="submit" value="送信">
    </div>
    {{-- GET メソッド以外でリクエストする場合は、@csrfを含める --}}
    @csrf
</form>
