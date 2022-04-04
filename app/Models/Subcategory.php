<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable=['title'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
