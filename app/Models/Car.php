<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
