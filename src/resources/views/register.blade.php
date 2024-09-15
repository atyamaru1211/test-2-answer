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
        <form method="POST" action="/product/upload" enctype="multipart/form-data">
        @csrf
            <label class="label">商品名<span class="require">必須</span></label>
            <input type="text" placeholder="商品名を入力" name="product_name" class="text">
            @error('product_name')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_name')}}</p>
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
            <input type="file" id="product_image" class="image" name="product_image">
            @error('product_image')
                <span class="input_error">
                    <p class="input_error_message">{{$errors->first('product_image')}}</p>
                </span>
            @enderror
            <label class="label">季節<span class="require">必須</span><span class="note">複数選択可</span></label>
            @foreach ($seasons as $season)
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
</body>
</html>