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
            $result = DB::table('movies')
                        ->select('movies.title', 'movies.name_english', 'movies.type_movie','episodes.episode', 'episodes.server_id', 'episodes.linkphim')
                        ->rightJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
                        ->where('movies.imdb', $params) 
                        ->get(); 

            if ($result->isNotEmpty()) {
                $result = $result->map(function ($item) {
                        $parts = explode('link=', $item->linkphim);
                        $item->linkphim = $parts[1] ?? $item->linkphim;
                        return $item;
                    })
                    ->groupBy('title') 
                    ->map(function ($items) {
                        return [
                            'title' => $items->first()->title,
                            'name_english' => $items->first()->name_english,
                            'type' => $items->first()->type_movie,
                            'episodes' => $items->groupBy('server_id')->map(function ($serverItems, $server_id) {
                                return [
                                    'server_id' => $server_id,
                                    'episode' => $serverItems->map(function ($serverItem) {
                                        return [
                                            'episode' => $serverItem->episode,
                                            'linkphim' => $serverItem->linkphim
                                        ];
                                    })
                                ];
                            })->values()
                        ];
                    })->values()->first();
            }
            return $result;
        }
    
    }

}
