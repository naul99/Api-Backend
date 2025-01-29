<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\EpisodeModel;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public $model;
    public $item;
    public function __construct(Request $request)
    {
        // parent::__construct($request);
        $this->model = new EpisodeModel();
    }
    public function episode($id){
        $this->item['imdb'] = $id;
        $item = $this->item = $this->model->getItem($this->item['imdb'], ['task' => "get-item"]);

        return response()->json(['status'=> 200,'data'=>$item]);
    }
}
