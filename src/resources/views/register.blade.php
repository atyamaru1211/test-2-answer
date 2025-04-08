<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
</head>
<body>
    <main class="main-contents">
        <h1>商品登録</h1>
        <form method="POST" action="/products" enctype="multipart/form-data"><!--enctype="multipart/form-data"は、フォームでファイルをアップロードする場合に必ず必要。-->
        @csrf
            <label class="label">商品名<span class="require">必須</span></label>
            <input type="text" placeholder="商品名を入力" name="product_name" class="text">
            @error('product_name')
                <span class="input_error"><!--バリデーションは、書いてる順にチェックされる。firstって書いとけば、最初のエラーでだけ文章が出る-->
                    <p class="input_error_message">{{$errors->first('product_name')}}</p><!--product_nameに関する最初のエラーメッセージを取得-->
                </span>
            @enderror
            <label class="label">値段<span class="require">必須</span></label>
            <input type="text" class="text" placeholder="値段を入力" name="product_price">
            @error('product_price')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_price')}}</p>
                </span>
            @enderror
            <label class="label">商品画像<span class="require">必須</span></label>
            <output id="list" class="image_output"></output>
            <input type="file" id="product_image" class="image" name="product_image">
            @error('product_image')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_image')}}</p>
                </span>
            @enderror
            <label class="label">季節<span class="require">必須</span><span class="note">複数選択可</span></label>
            @foreach ($seasons as $season)<!--繰り返す-->
                <input type="checkbox" id="season" value="{{$season->id}}" name="product_season">
                <label for="season">{{$season->name}}</label>
            @endforeach
            @error('product_season')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_season')}}</p>
                </span>
            @enderror
            <label class="label">商品説明<span class="require">必須</span></label>
            <textarea cols="30" rows="5" placeholder="商品の説明を入力" name="product_description" class="textarea"></textarea>
            @error('product_description')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_description')}}</p>
                </span>
            @enderror
            <div class="button-content">
                <a href="/products" class="back">戻る</a>
                <button type="submit" class="button-register">登録</button>
            </div>
        </form>
    </main>
    <!--JavaScriptのコードを記述するためのタグ。これは、ユーザーがファイル選択フィールドで画像ファイルを選択すると、その場でプレビューを表示する機能を実現している-->
    <script>
        //ファイルが選択されたときに実行される内容
        document.getElementById('product_image').onchange = function(event){
            //以前に選択されたファイルを削除する
            initializeFiles();
            //選択されたファイルのリストをfiles変数に格納
            var files = event.target.files;
            //選択されたファイルの数だけループ処理を行う
            for (var i = 0, f; f = files[i]; i++) {
                //FileReaderオブジェクトのインスタンスを作成。（FileReader：ユーザーのコンピューターに保存されたファイルの内容を読み取るためのAPI）
                var reader = new FileReader;
                //現在のファイル（f）の内容をDataURLとして読み込む
                reader.readAsDataURL(f);
                //ファイルの読み込みが完了したときに発生するonloadイベント
                reader.onload = (function(theFile) {
                    //よくわからん。。
                    return function (e) {
                        //新しいdiv要素を作る
                        var div = document.createElement('div');
                        //class名はreader_file
                        div.className = 'reader_file';
                        //その中にimgタグを追加。読み込まれた画像データのURLを含む
                        div.innerHTML += '<img class="reader_image" src="' + e.target.result + '" />';
                        //listの子要素として、作成したdiv要素を挿入
                        document.getElementById('list').insertBefore(div, null);
                    }
                })(f);
            }
        };

        function initializeFiles() {
            document.getElementById('list').innerHTML = '';
        }

    </script>
</body>
</html>