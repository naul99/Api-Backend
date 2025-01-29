<?php

namespace App\Models\Api;

use App\Models\BackendModel;
use DB;
use Illuminate\Database\Eloquent\Model;

class EpisodeModel extends BackendModel
{
    // public function __construct()
    // {
    //     $this->table        = TABLE_EPISODE;
        
    //     parent::__construct();
    // }
    public function getItem($params, $options = []){
        if ($options['task'] == 'get-item') {
            $result = null;
            $result = DB::table('movies')->select('title','name_english','episode','server_id','linkphim')
                        ->rightJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
                        ->where('movies.imdb', $params)->get();

            $result = $result->map(function ($item) {
                $parts = explode('link=', $item->linkphim);
                $item->linkphim = $parts[1] ?? $item->linkphim;
            
                return $item;
            });
                    
            return $result;
        }
    
    }

}
