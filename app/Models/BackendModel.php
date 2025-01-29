<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackendModel extends Model
{
    protected $table            = '';
    protected $folderUpload     = '' ;
    protected $connection       = 'mysql';
    protected $_data                  = [];
    public $timestamps      = false;
    public function __construct($connection = 'mysql')
    {
        $this->connection = $connection;
        $this->primaryKey = $this->columnPrimaryKey();
    }
    public function columnPrimaryKey($key = 'id')
    {
        return $key;
    }
}
