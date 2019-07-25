<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'age', 'city'];

    public function song(){
    	return $this->hasMany('App\Song','author_id','id');
    }
}


// comment thu 3
// tao comment thu 2
