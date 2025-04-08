<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>
    <div class="all-contents">
        <form action="/update" method ="POST"><!--何かしら送信ボタンが押されたら/updateに飛ぶ-->
        @csrf
            <div class="top-contents">
                <div class="left-content">
                    <p><span class="span-item">商品一覧></span>{{$product->name}}</p>
                    <img src="{{ asset($product->image) }}"  alt="店内画像" class="img-content"/><!--商品画像-->
                </div>
                <div class="right-content">
                    <label class="name-label">商品名</label><!--下の入力欄についてのラベル-->
                    <input type="text" placeholder="{{$product->name}}" name="product_name" class="text"><!--ここでのnameは、フォームで送信される際のパラメータ名-->
                    <label class="price-label">値段</label>
                    <input type="text" placeholder="{{$product->price}}" name="product_price" class="text">
                    <label class="season-label">季節</label><!--チェックボックス-->
                    @foreach ($seasons as $season)<!--普通４つだけど、登録している季節の数だけ繰り返される-->
                        <label for="season">{{$season->name}}</label><!--その季節名をクリックしても、マークにチェックが付くようにfor=seasonって書いて、-->
                        @if($product->checkSeason($season,$product) == "no")<!--もし季節とproductが関連づいてなければ-->
                            <input type="checkbox" id="season" value="{{$season->id}}"><!--チェックなし。（id=seasonで上とそろえてる）-->
                        @elseif($product->checkSeason($season,$product) == "yes")<!--関連づいていれば-->
                            <input type="checkbox" id="season" value="{{$season->id}}" checked><!--チェック有。-->
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="under-content">
                <input type="file" id="product_image" class="image" name="product_image"><!--ファイルをアップロードするためのinput要素。「ファイルを選択」ってボタンのところ。-->
                <label class="description-label">商品説明</label>
                <textarea cols="30" rows="5" name="product_description" class="product-description">{{$product->description}}</textarea>
                <!--colsは、テキストエリアの幅を半角文字30文字に設定する。rowはテキストエリアの高さを5行にする。-->
                <div class="button-content">
                    <a href="/products" class="back">戻る</a>
                    <button type="submit" class="button-change">変更を保存</button>
                    <div class="trash-can-content">
                        <form action="/products/{{$product->id}}/delete" method="POST">
                            @method('delete')
                            @csrf
                            <button class="delete-button" type="submit">
                                <img src="{{ asset('/images/trash-can.png') }}"  alt="ゴミ箱の画像" class="img-trash-can"/>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<!--もし、バリデーション表示時のゴミ箱ボタン非表示にするには、
                    <button type="submit" class="button-change">変更を保存</button>
            追加    @if ($errors->isEmpty()) 
                    <div class="trash-can-content">
                        <form action="/products/{{$product->id}}/delete" method="POST">
                            @method('delete')
                            @csrf
                            <button class="delete-button" type="submit">
                                <img src="{{ asset('/images/trash-can.png') }}"  alt="ゴミ箱の画像" class="img-trash-can"/>
                            </button>
                        </form>
                    </div>
            追加    @endif
-->