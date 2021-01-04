<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $table = 'products';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
