<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $fillable = [
		'name', 'detail','author_id'
	];
	
	public function authors(){
		return $this->belongsTo('App\Author','author_id','id');
	}
}
