<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録ページ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/list.css') }}" />
</head>
<body>
    <main>
        <h1>商品登録</h1>
        <form method="POST" action="/product/upload" enctype="multipart/form-data">
        @csrf
            <label>商品名</label>
            <input type="text" placeholder="商品名を入力" name="product_name">
            <label>値段</label>
            <input type="text" class="" placeholder="値段を入力" name="product_price">
            <label>商品画像</label>
            <input type="file" id="product_image" class="image" name="product_image">
            <label>季節</label>
            <select name="product_season">
                @foreach ($seasons as $season)
                    <option value="{{$season->name}}">{{$season->name}}</option>
                @endforeach
            </select>
            <label>商品説明</label>
            <textarea cols="30" rows="5" placeholder="商品の説明を入力" name="product_description"></textarea>
            <button type="submit">登録</button>
        </form>
    </main>
</body>
</html>