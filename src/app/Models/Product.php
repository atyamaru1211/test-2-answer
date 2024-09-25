<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function seasons()
    {
        return $this->belongsToMany(Season::class,'product_season','product_id','season_id',);
    }

    public function checkSeason($season,$product)
    { 
        $season_id = $season->id;
        $product_id = $product->id;

        $product_data = Product::find($product_id);
        $productSeasons = $product_data->seasons; 
        
        foreach ($productSeasons as $productSeason) 
        {
            if($productSeason->id == $season_id)
            {
                $returnTxt ="yes";

                return $returnTxt;
            }
        }
        
        if($productSeason->id != $season_id)
        {
            $returnTxt ="no";

            return $returnTxt;
        }
    }

}
