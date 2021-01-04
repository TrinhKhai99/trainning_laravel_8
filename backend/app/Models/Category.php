<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $table = 'category';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
