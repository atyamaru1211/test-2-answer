<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
</head>
<body>
    <div class="all-contents">
        <div class="left-contents">
            <h1>商品一覧</h1>
            <!--ここのメソッドをGETにして、ルートも直したら、コントローラのgetSearchとpostSearchを合体できる-->
            <form action="/products/search" method = "GET"><!--検索フォームを定義するform。actionはフォームのデータが送信される場所。-->
            @csrf
                <input type="text" name="keyword" class="keyword" placeholder="商品名で検索">
                <button type="submit" class="submit-button">検索</button><!--type=submitのボタンをクリックすると、form要素のデータがactionのURLにmethod属性で指定されたメソッドで送られる-->
                <label class="select-label">価格順で表示</label><!--下のselectでつけるラベルの名前--><!---->
                <select class="select" name="sort" id="sort">
                    <option value="">価格で並び替え</option>
                    <option value="high_price">高い順に表示</option>
                    <option value="low_price">低い順に表示</option>
                </select>
            </form>
            @if(@isset($sort)&& $sort != "")<!--sort変数が存在し、かつ空じゃない場合のみにif内を実行。-->
                <div class="sort_contents">
                    <p class="searched_data">{{$sort}}</p><!--「高い順に表示」や「低い順に表示」というマーク-->
                    <div class="close-content"><!--閉じるボタン-->
                        <a href="/products"><!--閉じるボタンを押した場合の戻る場所。-->
                            <img src="{{ asset('/images/close-icon.png') }}"  alt="閉じるアイコン" class="img-close-icon"/><!--閉じるボタン-->
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="right-contents">
            <p class="message">{{session('message')}}</p><!--削除したときのメッセージ。コントローラで設定されてるよ。-->
            <a href="/products/register" class="add-button"><span>+</span>商品を追加</a>
            <div class="product-contents"><!--商品リスト-->
                @foreach ($products as $product)
                    <div class="product-content">
                        <a href="/products/detail/{{$product->id}}" class="product-link"></a><!--商品詳細ページへ飛べるように。データを入力するわけではないからformじゃなくていい-->
                        <img src="{{ asset($product->image) }}"  alt="商品画像" class="img-content"/>
                        <div class="detail-content">
                            <p>{{$product->name}}</p>
                            <p>{{$product->price}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-content">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                <!--Laravelのテンプレ。ページネーションのリンク。-->
                <!--appends(request()->query()):ページを移動しても検索条件や並び替え条件が維持される-->
                <!--links('pagination::bootstrap-4'):Laravelのデフォルトのページネーションビュー-->
            </div>
        </div>
    </div>
</body>
</html>