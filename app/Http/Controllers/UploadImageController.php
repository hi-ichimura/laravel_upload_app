<?php

namespace App\Http\Controllers;

use App\Models\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/* Laravelの拡張クラス Str を読み込み */
use Illuminate\Support\Str;

class UploadImageController extends Controller
{
    /* POST 送信された画像ファイルを受け取って、storageに保存する */
    public function upload(Request $request)
    {
        /* バリデーション */
        $request->validate([
            'image' => 'required|max:1024|mimes:jpg,jpeg,png,gif'
        ]);

        /* store('保存先ディレクトリ', 'ディスク') メソッドで、ファイルをstorage/public/images ディレクトリに保存する
         * ファイル名はランダム文字列になり、store()の返り値として取得できる
         * 第2引数は、config/filesystems.php で設定したdisks 配列のキーから指定する
         */
        $file_path = $request->image->store('images', 'public');

        $auth_info = Auth::user()->id;
        /* UploadImage オブジェクトを生成 */
        $upload_image = new UploadImage();
        $upload_image->filename = $request->image->getClientOriginalName();
        $upload_image->memo = $request->memo;
        $upload_image->filepath = $file_path;
        /*アップロードしたユーザーID*/
        $upload_image->user_id = $auth_info;

        /* データベースにレコードを追加する */
        $upload_image->save();

        /* 保存した画像を表示する */
        print("<img src='". asset("$file_path"). "' width='300'>");

        print("<a href='upload_form'>画像投稿フォームに戻る</a>");

    }

     /* 画像の一覧画面を表示する */
     public function index(Request $request)
     {
         /* Requestに送信された検索キーワードを変数に保持 */
         $keyword = $request->input('keyword');

        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) { // Str::length(<文字列>) で、文字列の長さを取得できる
            $upload_images = UploadImage::where('filename', 'LIKE', "%$keyword%") // ファイル名にkeyword を含むものを絞り込み
                ->orWhere('memo', 'LIKE', "%$keyword%") // 備考にkeyword を含むものを絞り込み
                ->get();
        } else {
            /* 検索キーワードが入力されていない場合は、全件取得する */
            $upload_images = UploadImage::all();
        }

         return view('upload_images', compact('keyword', 'upload_images'));
     }

     public function index_my(Request $request)
     {

         $auth_info = Auth::user()->id;
           /* Requestに送信された検索キーワードを変数に保持 */
         $keyword = $request->input('keyword');

        /* 検索キーワードが入力されている場合、表示するデータを絞り込む */
        if (Str::length($keyword) > 0) {
            //ログインしているユーザーの写真のみ表示
            $upload_images = UploadImage::where('user_id', '=', "$auth_info")
                ->where(function($query) use($keyword){
                    $query->where('filename', 'LIKE', "%$keyword%")
                          ->orWhere('memo', 'LIKE', "%$keyword%");
                })->get();
        }else{
            $upload_images = UploadImage::where('user_id', '=', "$auth_info")->get();
        }

         return view('my_upload_images', compact('keyword','upload_images'));
     }
     public function delete($id)
     {
        //$auth_info = Auth::user()->id;
         $upload_images_delete = UploadImage::find($id);

         $upload_images_delete->delete();

         return redirect('my_upload');
     }

     public function edit($id)
     {
        //$auth_info = Auth::user()->id;
        $upload_images_edit = UploadImage::find($id);

         return view('my_edit_images',compact('upload_images_edit'));
     }

     public function update(Request $request, $id)
    {
        /* バリデーション
        $request->validate([
            'image' => 'required|max:1024|mimes:jpg,jpeg,png,gif'
        ]);
        */

        /* Contact モデルで、編集する対象のデータを取得する */
        $my_update_images = UploadImage::find($id);

        /* リクエストで渡された値を設定する */
        $my_update_images->filename = $request->filename;
        $my_update_images->memo = $request->memo;

        /* データベースに保存 */
        $my_update_images->save();

        /* 一覧画面に戻る */
        return redirect('my_upload');
    }


}
