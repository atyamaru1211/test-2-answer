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
        <form action="/update" method ="POST">
        @csrf
            <div class="top-contents">
                <div class="left-content">
                    <p><span class="span-item">商品一覧></span>{{$product->name}}</p>
                    <img src="{{ asset($product->image) }}"  alt="店内画像" class="img-content"/>
                </div>
                <div class="right-content">
                    <label class="name-label">商品名</label>
                    <input type="text" placeholder="{{$product->name}}" name="product_name" class="text">
                    <label class="price-label">値段</label>
                    <input type="text" placeholder="{{$product->price}}" name="product_price" class="text">
                    <label class="season-label">季節</label>
                    @foreach ($seasons as $season)
                        <label for="season">{{$season->name}}</label>
                        @if($product->checkSeason($season,$product) == "no")
                            <input type="checkbox" id="season" value="{{$season->id}}">
                        @elseif($product->checkSeason($season,$product) == "yes")
                            <input type="checkbox" id="season" value="{{$season->id}}" checked>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="under-content">
                <input type="file" id="product_image" class="image" name="product_image">
                <label class="description-label">商品説明</label>
                <textarea cols="30" rows="5" name="product_description" class="product-description">{{$product->description}}</textarea>
                <div class="button-content">
                    <a href="/products" class="back">戻る</a>
                    <button type="submit" class="button-change">変更を保存</button>
                    <div class="trash-can-content">
                        <a href="/products/{{$product->id}}/delete">
                            <img src="{{ asset('/images/trash-can.png') }}"  alt="ゴミ箱の画像" class="img-trash-can"/>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>