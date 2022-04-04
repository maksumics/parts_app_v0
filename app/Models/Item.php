<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'code', 'price', 'amount', 'active', 'details'];

    public function subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory');
    }
    public function car()
    {
        return $this->belongsTo('App\Models\Car');
    }
    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }
}
