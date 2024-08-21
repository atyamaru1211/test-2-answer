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
            <form action="//products/search" method = "POST">
            @csrf
                <input type="text" name="keyword" class="keyword" placeholder="商品名で検索">
                <button type="submit" class="submit-button">検索</button>
            </form>
            <label class="select-label">価格順で表示</label>
            <select class="select" name="sort" id="sort">
                <option value="high_price">高い順に表示</option>
                <option value="low_price">低い順に表示</option>
            </select>
        </div>
        <div class="right-contents">
            <a href="/products/register" class="add-button"><span>+</span>商品を追加</a>
            <div class="product-contents">
            @foreach ($products as $product)
                <div class="product-content">
                    <a href="products/{{$product->id}}" class="product-link"></a>
                    <img src="{{ asset($product->image) }}"  alt="商品画像" class="img-content"/>
                    <div class="detail-content">
                        <p>{{$product->name}}</p>
                        <p>{{$product->price}}</p>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</body>
</html>