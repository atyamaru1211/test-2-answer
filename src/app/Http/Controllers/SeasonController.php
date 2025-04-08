<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Season;

class SeasonController extends Controller
{
    public function create()
    {
        $seasons = Season::all();

        return view('register', compact('seasons'));
    }
}

 /*このコントローラは、商品登録フォームを表示する際に、データベースから全ての季節データを取得してビューに渡すという役割がある*/