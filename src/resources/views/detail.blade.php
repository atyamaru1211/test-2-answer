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
        <p>商品一覧>{{$product->name}}</p>
        <img src="{{ asset($product->image) }}"  alt="店内画像" class="img-content"/>
        <label>商品名</label>
        <input type="text" placeholder="{{$product->name}}" name="product_name">
        <label>値段</label>
        <input type="text" class="" placeholder="{{$product->price}}" name="product_price">
        <label>季節</label>
        @foreach ($seasons as $season)
            <label for="season">{{$season->name}}</label>
            <input type="checkbox" id="season" value="{{$season->id}}">
        @endforeach
    </div>
</body>
</html>