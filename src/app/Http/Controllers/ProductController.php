<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Pagination\Paginator; /*Laravelのページネーション機能を提供してくれる*/
use Illuminate\Pagination\LengthAwarePaginator; /*Laravelの総件数を伴うページネーション機能を提供してくれる*/
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
     /*商品一覧ページ　本来はindex　ページネーションの設定ばっかり*/
    public function index()
    {
        $products = Product::all(); /*productsテーブルから全件取得*/
        $perPage = 6; /*1ページあたり6個*/
        $page = Paginator::resolveCurrentPage('page'); /*現在のページ番号をクエリパラメータ(GETメソッドでやり取りされるときのURLの最後の文字列)pageから取得*/
        $pageData = $products->slice(($page - 1) * $perPage, $perPage); /*取得した全ての商品データから、現在のページに表示する分のデータを切り出す*/
        $options = [ /*ページネーションのオプションを定義する*/
            'path' => Paginator::resolveCurrentPath(), /*ページネーションリンクのURLを現在のURLに設定*/
            'pageName' => 'page' /*ページ番号のクエリパラメータ名をpageに設定*/
        ];

         /*上で色々定義したものをひっくるめてproductsに再代入する*/
        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);
         /*生成したページネーションオブジェクトproductsをlistビューに渡して表示*/
        return view('list', compact('products'));
    }

     /*商品登録フォームから送信されたデータを受け取り登録する　本来はstore*/
    public function store(ProductRequest $request)
    {
        $dir = 'images'; /*アップロードされた画像を保存するディレクトリ名をdir箱の中に設定*/

        $file_name = $request->file('product_image')->getClientOriginalName(); /*アップロードされたproduct_imageの元々のファイル名を取得しfile_name箱に格納*/
        $request->file('product_image')->storeAs('public/' . $dir, $file_name); /*アップロードされたproduct_imageを、public内のdirで指定されたディレクトリに元々の名前で保存*/

        $product = new Product(); /*新しいProductモデルを作り、productって箱に入れる*/
         /*それぞれ、フォームから送信されたデータを、作成したproductに代入している*/
        $product->name= $request->input('product_name');
        $product->price= $request->input('product_price');
        $product->image= 'storage/' . $dir . '/' . $file_name;
        $product->description= $_POST["product_description"];
        $product->save(); /*で、最後データベースのproductsテーブルに保存する*/

         /*ここの部分は、getProduct(index)の部分とまったく一緒。ページネーションの設定*/
        $products = Product::all();
        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);

        return redirect('/products'); /*何らかのフォーム送信後はviewではなくredirectを使う*/
    }

     /*商品検索*/
    public function search(Request $request)
    {
        $query = Product::query(); /*クエリビルダを取得*/
        $sort = $request->input('sort'); /*name=sortを取得し、sort箱に格納*/

        if ($sort == "高い順に表示") { /*もし箱の中身が「高い順に表示」であれば以下の処理*/

            $sort = "high_price"; /*内部処理用にhigh_priceに変更*/

        }
        elseif ($sort == "低い順に表示") { /*もし「低い順に表示」であれば*/

            $sort = "low_price"; /*内部処理用にlow_priceに変更*/

        }
        else{ /*どれでもない場合は*/

            $sort = ""; /*空（デフォルト）のまま*/
        }

        if ($request->filled('keyword')) { /*もしname=keywordが存在してたら以下の処理*/

            $keyword = $request->input('keyword'); /*リクエストからname=keywordの値を取り出し、箱に格納*/
            $query->where('name','like','%'.$keyword.'%'); /*検索の箱に色々追加。nameにキーワードが含まれているレコードを探す*/

        }

        $query_products = $query->get(); /*これまで作った検索箱を実行し、当てはまるすべてのproductを取得しquery_productsに格納。並び替えはまだ*/

        if($sort == "high_price"){ /*その検索されたやつを、今度は並び替える。もしsortの値がhigh_priceなら*/

            $products = $query_products->sortByDesc('price'); /*検索結果を並び替え、products箱に格納。Descは降順(大きい者から並べる)*/
            $sort = "高い順に表示"; /*ユーザーには「高い順に表示」を表示*/

        }elseif($sort == "low_price"){ /*もしlow_priceなら*/

            $products = $query_products->sortBy('price'); /*低い順に並べ替える*/
            $sort = "低い順に表示";


        }else{ /*それかどっちでもないなら*/

            $products = $query_products; /*そのまんま*/
            $sort = "";

        }
         /*ここも、最初と同じに*/
        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];
        
        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options); /*検索結果にもページネーション機能が追加される*/

        $products->appends(['sort' => $sort]); /*生成したページネーションリンクにsortパラメータを追加する。別のページに移動しても、選択した並び順が維持される*/

        $seasons = Season::all(); /*Seasonも全件取得*/

        return view('list')->with(compact('sort','products','seasons')); /*箱たちをlistビューに渡して表示*/
    }

     /*削除機能*/
    public function destroy($product_id)
    {
        $product = Product::find($product_id); /*product_idに一致するIDを持つ商品を取得し箱に格納*/
        $product->delete(); /*で、それを消す*/
        $message = "製品の削除が完了しました。"; /*メッセージも出しちゃう。*/

        return redirect('/products')->with(compact('products','message')); /*再診の商品リストとメッセージを添えて*/
    }

     /*詳細画面の表示*/
    public function show($product_id)
    {
        $product = Product::find($product_id); 
        $seasons = Season::all(); 

        return view('detail', compact('product','seasons'));
    }
}




     /*これいらない！
     検索機能　indexかも？　ページ遷移時の並び順の維持のためにpostSearchが書かれてる
    public function postSearch(Request $request)
    {
        $query = Product::query();
        $sort = $request->input('sort');

        if ($request->filled('keyword')) {

            $keyword = $request->input('keyword');
            $query->where('name','like','%'.$keyword.'%');

        }

        $query_products = $query->get();

        if($sort == "high_price"){

            $products = $query_products->sortByDesc('price');
            $sort = "高い順に表示";

        }elseif($sort == "low_price"){

            $products = $query_products->sortBy('price');
            $sort = "低い順に表示";


        }else{

            $products = $query_products;
            $sort = "";

        }

        $perPage = 6;
        $page = Paginator::resolveCurrentPage('page');
        $pageData = $products->slice(($page - 1) * $perPage, $perPage);
        $options = [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page'
        ];

        $products = new LengthAwarePaginator($pageData, $products->count(), $perPage, $page, $options);

        $products->appends(['sort' => $sort]); 

        $seasons = Season::all();

        return view('list')->with(compact('sort','products','seasons'));
    }
    */

