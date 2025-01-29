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
            ->select('movies.title', 'movies.name_english', 'episodes.episode', 'episodes.server_id', 'episodes.linkphim')
            ->rightJoin('episodes', 'movies.id', '=', 'episodes.movie_id')
            ->where('movies.imdb', $params)
            ->get()
            ->map(function ($item) {
                $parts          = explode('link=', $item->linkphim);
                $item->linkphim = $parts[1] ?? $item->linkphim;
                return $item;
            })
            ->groupBy('title')
            ->map(function ($items) {
                return [
                    'title'         => $items->first()->title,
                    'name_english'  => $items->first()->name_english,
                    'episodes'      => $items->map(function ($ep) {
                        return [
                            'episode'   => $ep->episode,
                            'server_id' => $ep->server_id,
                            'linkphim'  => $ep->linkphim
                        ];
                    })->values()
                ];
            })->values();
        
            return $result;
        }
    
    }

}
