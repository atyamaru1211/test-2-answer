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

    public function checkSeason($season)
    { 
        $productSeasons = $this->seasons();
        $season_id = $season->id;
        
        foreach ($productSeasons as $productSeason) 
        {
            if($productSeason->id == $season_id)
            {
                $returnTxt ="yes";

                return $returnTxt;
            }
            else
            {
                $returnTxt ="no";

                return $returnTxt;
            }
        }
        
    }

}
